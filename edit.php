<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Manage files in folderexamtimer module instance
 *
 * @package   mod_folderexamtimer
 * @copyright 2010 Dongsheng Cai <dongsheng@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once("$CFG->dirroot/mod/folderexamtimer/locallib.php");
require_once("$CFG->dirroot/mod/folderexamtimer/edit_form.php");
require_once("$CFG->dirroot/repository/lib.php");

$id = required_param('id', PARAM_INT);  // Course module ID

$cm = get_coursemodule_from_id('folderexamtimer', $id, 0, true, MUST_EXIST);
$context = context_module::instance($cm->id, MUST_EXIST);
$folderexamtimer = $DB->get_record('folderexamtimer', array('id'=>$cm->instance), '*', MUST_EXIST);
$course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);

require_login($course, false, $cm);
require_capability('mod/folderexamtimer:managefiles', $context);

$PAGE->set_url('/mod/folderexamtimer/edit.php', array('id' => $cm->id));
$PAGE->set_title($course->shortname.': '.$folderexamtimer->name);
$PAGE->set_heading($course->fullname);
$PAGE->set_activity_record($folderexamtimer);

$data = new stdClass();
$data->id = $cm->id;
$maxbytes = get_user_max_upload_file_size($context, $CFG->maxbytes);
$options = array('subdirs' => 1, 'maxbytes' => $maxbytes, 'maxfiles' => -1, 'accepted_types' => '*');
file_prepare_standard_filemanager($data, 'files', $options, $context, 'mod_folderexamtimer', 'content', 0);

$mform = new mod_folderexamtimer_edit_form(null, array('data'=>$data, 'options'=>$options));
if ($folderexamtimer->display == folderexamtimer_DISPLAY_INLINE) {
    $redirecturl = course_get_url($cm->course, $cm->sectionnum);
} else {
    $redirecturl = new moodle_url('/mod/folderexamtimer/view.php', array('id' => $cm->id));
}

if ($mform->is_cancelled()) {
    redirect($redirecturl);

} else if ($formdata = $mform->get_data()) {
    $formdata = file_postupdate_standard_filemanager($formdata, 'files', $options, $context, 'mod_folderexamtimer', 'content', 0);
    $folderexamtimer->timemodified = time();
    $folderexamtimer->revision = $folderexamtimer->revision + 1;

    $DB->update_record('folderexamtimer', $folderexamtimer);

    $params = array(
        'context' => $context,
        'objectid' => $folderexamtimer->id
    );
    $event = \mod_folderexamtimer\event\folderexamtimer_updated::create($params);
    $event->add_record_snapshot('folderexamtimer', $folderexamtimer);
    $event->trigger();

    redirect($redirecturl);
}

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($folderexamtimer->name));
echo $OUTPUT->box_start('generalbox folderexamtimertree');
$mform->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();
