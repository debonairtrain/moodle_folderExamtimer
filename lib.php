<?php
error_reporting(0);
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
 * Mandatory public API of folderexamtimer module
 *
 * @package   mod_folderexamtimer
 * @copyright 2009 Petr Skoda  {@link http://skodak.org}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/** Display folderexamtimer contents on a separate page */
define('FOLDEREXAMTIMER_DISPLAY_PAGE', 0);
/** Display folderexamtimer contents inline in a course */
define('FOLDEREXAMTIMER_DISPLAY_INLINE', 1);
require_once($CFG->libdir . '/completionlib.php');


/**
 * List of features supported in folderexamtimer module
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, false if not, null if doesn't know
 */
function folderexamtimer_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_ARCHETYPE:           return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_GROUPS:                  return false;
        case FEATURE_GROUPINGS:               return false;
        case FEATURE_MOD_INTRO:               return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return true;
        case FEATURE_GRADE_HAS_GRADE:         return false;
        case FEATURE_GRADE_OUTCOMES:          return false;
        case FEATURE_BACKUP_MOODLE2:          return true;
        case FEATURE_SHOW_DESCRIPTION:        return true;
        case FEATURE_COMPLETION_HAS_RULES: return true;
        default: return null;
    }
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 * @param $data the data submitted from the reset course.
 * @return array status array
 */
function folderexamtimer_reset_userdata($data) {

    // Any changes to the list of dates that needs to be rolled should be same during course restore and course reset.
    // See MDL-9367.

    return array();
}

/**
 * List the actions that correspond to a view of this module.
 * This is used by the participation report.
 *
 * Note: This is not used by new logging system. Event with
 *       crud = 'r' and edulevel = LEVEL_PARTICIPATING will
 *       be considered as view action.
 *
 * @return array
 */
function folderexamtimer_get_view_actions() {
    return array('view', 'view all');
}

/**
 * List the actions that correspond to a post of this module.
 * This is used by the participation report.
 *
 * Note: This is not used by new logging system. Event with
 *       crud = ('c' || 'u' || 'd') and edulevel = LEVEL_PARTICIPATING
 *       will be considered as post action.
 *
 * @return array
 */
function folderexamtimer_get_post_actions() {
    return array('update', 'add');
}

/**
 * Add folderexamtimer instance.
 * @param object $data
 * @param object $mform
 * @return int new folderexamtimer instance id
 */
function folderexamtimer_add_instance($data, $mform) {
    global $DB;

    $cmid        = $data->coursemodule;
    $draftitemid = $data->files;

    $data->timemodified = time();
    // If 'showexpanded' is not set, apply the site config.
    if (!isset($data->showexpanded)) {
        $data->showexpanded = get_config('folderexamtimer', 'showexpanded');
    }
    $data->id = $DB->insert_record('folderexamtimer', $data);

    // we need to use context now, so we need to make sure all needed info is already in db
    $DB->set_field('course_modules', 'instance', $data->id, array('id'=>$cmid));
    $context = context_module::instance($cmid);

    if ($draftitemid) {
        file_save_draft_area_files($draftitemid, $context->id, 'mod_folderexamtimer', 'content', 0, array('subdirs'=>true));
    }

    $completiontimeexpected = !empty($data->completionexpected) ? $data->completionexpected : null;
    \core_completion\api::update_completion_date_event($data->coursemodule, 'folderexamtimer', $data->id, $completiontimeexpected);

    return $data->id;
}

/**
 * Update folderexamtimer instance.
 * @param object $data
 * @param object $mform
 * @return bool true
 */
function folderexamtimer_update_instance($data, $mform) {
    global $CFG, $DB;

    $cmid        = $data->coursemodule;
    $draftitemid = $data->files;

    $data->timemodified = time();
    $data->id           = $data->instance;
    $data->revision++;

    $DB->update_record('folderexamtimer', $data);

    $context = context_module::instance($cmid);
    if ($draftitemid = file_get_submitted_draft_itemid('files')) {
        file_save_draft_area_files($draftitemid, $context->id, 'mod_folderexamtimer', 'content', 0, array('subdirs'=>true));
    }

    $completiontimeexpected = !empty($data->completionexpected) ? $data->completionexpected : null;
    \core_completion\api::update_completion_date_event($data->coursemodule, 'folderexamtimer', $data->id, $completiontimeexpected);

    return true;
}

/**
 * Delete folderexamtimer instance.
 * @param int $id
 * @return bool true
 */
function folderexamtimer_delete_instance($id) {
    global $DB;

    if (!$folderexamtimer = $DB->get_record('folderexamtimer', array('id'=>$id))) {
        return false;
    }

    $cm = get_coursemodule_from_instance('folderexamtimer', $id);
    \core_completion\api::update_completion_date_event($cm->id, 'folderexamtimer', $folderexamtimer->id, null);

    // note: all context files are deleted automatically

    $DB->delete_records('folderexamtimer', array('id'=>$folderexamtimer->id));

    return true;
}

/**
 * Lists all browsable file areas
 *
 * @package  mod_folderexamtimer
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @return array
 */
function folderexamtimer_get_file_areas($course, $cm, $context) {
    $areas = array();
    $areas['content'] = get_string('folderexamtimercontent', 'folderexamtimer');

    return $areas;
}

/**
 * File browsing support for folderexamtimer module content area.
 *
 * @package  mod_folderexamtimer
 * @category files
 * @param file_browser $browser file browser instance
 * @param array $areas file areas
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param int $itemid item ID
 * @param string $filepath file path
 * @param string $filename file name
 * @return file_info instance or null if not found
 */
function folderexamtimer_get_file_info($browser, $areas, $course, $cm, $context, $filearea, $itemid, $filepath, $filename) {
    global $CFG;


    if ($filearea === 'content') {
        if (!has_capability('mod/folderexamtimer:view', $context)) {
            return NULL;
        }
        $fs = get_file_storage();

        $filepath = is_null($filepath) ? '/' : $filepath;
        $filename = is_null($filename) ? '.' : $filename;
        if (!$storedfile = $fs->get_file($context->id, 'mod_folderexamtimer', 'content', 0, $filepath, $filename)) {
            if ($filepath === '/' and $filename === '.') {
                $storedfile = new virtual_root_file($context->id, 'mod_folderexamtimer', 'content', 0);
            } else {
                // not found
                return null;
            }
        }

        require_once("$CFG->dirroot/mod/folderexamtimer/locallib.php");
        $urlbase = $CFG->wwwroot.'/pluginfile.php';

        // students may read files here
        $canwrite = has_capability('mod/folderexamtimer:managefiles', $context);
        return new folderexamtimer_content_file_info($browser, $context, $storedfile, $urlbase, $areas[$filearea], true, true, $canwrite, false);
    }

    // note: folderexamtimer_intro handled in file_browser automatically

    return null;
}

/**
 * Serves the folderexamtimer files.
 *
 * @package  mod_folderexamtimer
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool false if file not found, does not return if found - just send the file
 */
function folderexamtimer_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG, $DB;

    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    require_course_login($course, true, $cm);
    if (!has_capability('mod/folderexamtimer:view', $context)) {
        return false;
    }

    if ($filearea !== 'content') {
        // intro is handled automatically in pluginfile.php
        return false;
    }

    array_shift($args); // ignore revision - designed to prevent caching problems only

    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = "/$context->id/mod_folderexamtimer/content/0/$relativepath";
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        return false;
    }

    // Set security posture for in-browser display.
    if (!$forcedownload) {
        header("Content-Security-Policy: default-src 'none'; img-src 'self'");
    }

    // Finally send the file.
    send_stored_file($file, 0, 0, $forcedownload, $options);
}

/**
 * Return a list of page types
 * @param string $pagetype current page type
 * @param stdClass $parentcontext Block's parent context
 * @param stdClass $currentcontext Current context of block
 */
function folderexamtimer_page_type_list($pagetype, $parentcontext, $currentcontext) {
    $module_pagetype = array('mod-folderexamtimer-*'=>get_string('page-mod-folderexamtimer-x', 'folderexamtimer'));
    return $module_pagetype;
}

/**
 * Export folderexamtimer resource contents
 *
 * @return array of file content
 */
function folderexamtimer_export_contents($cm, $baseurl) {
    global $CFG, $DB;
    $contents = array();
    $context = context_module::instance($cm->id);
    $folderexamtimer = $DB->get_record('folderexamtimer', array('id'=>$cm->instance), '*', MUST_EXIST);

    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'mod_folderexamtimer', 'content', 0, 'sortorder DESC, id ASC', false);

    foreach ($files as $fileinfo) {
        $file = array();
        $file['type'] = 'file';
        $file['filename']     = $fileinfo->get_filename();
        $file['filepath']     = $fileinfo->get_filepath();
        $file['filesize']     = $fileinfo->get_filesize();
        $file['fileurl']      = file_encode_url("$CFG->wwwroot/" . $baseurl, '/'.$context->id.'/mod_folderexamtimer/content/'.$folderexamtimer->revision.$fileinfo->get_filepath().$fileinfo->get_filename(), true);
        $file['timecreated']  = $fileinfo->get_timecreated();
        $file['timemodified'] = $fileinfo->get_timemodified();
        $file['sortorder']    = $fileinfo->get_sortorder();
        $file['userid']       = $fileinfo->get_userid();
        $file['author']       = $fileinfo->get_author();
        $file['license']      = $fileinfo->get_license();
        $file['mimetype']     = $fileinfo->get_mimetype();
        $file['isexternalfile'] = $fileinfo->is_external_file();
        if ($file['isexternalfile']) {
            $file['repositorytype'] = $fileinfo->get_repository_type();
        }
        $contents[] = $file;
    }

    return $contents;
}

/**
 * Register the ability to handle drag and drop file uploads
 * @return array containing details of the files / types the mod can handle
 */
function folderexamtimer_dndupload_register() {
    return array('files' => array(
                     array('extension' => 'zip', 'message' => get_string('dnduploadmakefolderexamtimer', 'mod_folderexamtimer'))
                 ));
}

/**
 * Handle a file that has been uploaded
 * @param object $uploadinfo details of the file / content that has been uploaded
 * @return int instance id of the newly created mod
 */
function folderexamtimer_dndupload_handle($uploadinfo) {
    global $DB, $USER;

    // Gather the required info.
    $data = new stdClass();
    $data->course = $uploadinfo->course->id;
    $data->name = $uploadinfo->displayname;
    $data->intro = '<p>'.$uploadinfo->displayname.'</p>';
    $data->introformat = FORMAT_HTML;
    $data->coursemodule = $uploadinfo->coursemodule;
    $data->files = null; // We will unzip the file and sort out the contents below.

    $data->id = folderexamtimer_add_instance($data, null);

    // Retrieve the file from the draft file area.
    $context = context_module::instance($uploadinfo->coursemodule);
    file_save_draft_area_files($uploadinfo->draftitemid, $context->id, 'mod_folderexamtimer', 'temp', 0, array('subdirs'=>true));
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'mod_folderexamtimer', 'temp', 0, 'sortorder', false);
    // Only ever one file - extract the contents.
    $file = reset($files);

    $success = $file->extract_to_storage(new zip_packer(), $context->id, 'mod_folderexamtimer', 'content', 0, '/', $USER->id);
    $fs->delete_area_files($context->id, 'mod_folderexamtimer', 'temp', 0);

    if ($success) {
        return $data->id;
    }

    $DB->delete_records('folderexamtimer', array('id' => $data->id));
    return false;
}

/**
 * Given a coursemodule object, this function returns the extra
 * information needed to print this activity in various places.
 *
 * If folderexamtimer needs to be displayed inline we store additional information
 * in customdata, so functions {@link folderexamtimer_cm_info_dynamic()} and
 * {@link folderexamtimer_cm_info_view()} do not need to do DB queries
 *
 * @param cm_info $cm
 * @return cached_cm_info info
 */
function folderexamtimer_get_coursemodule_info($cm) {
    global $DB;
    if (!($folderexamtimer = $DB->get_record('folderexamtimer', array('id' => $cm->instance),
            'id, name, display, showexpanded, showdownloadfolderexamtimer, completiondownload,forcedownload, intro, introformat'))) {
        return NULL;
    }
    $cminfo = new cached_cm_info();
    $cminfo->name = $folderexamtimer->name;
    if ($folderexamtimer->display == FOLDEREXAMTIMER_DISPLAY_INLINE) {
        // prepare folderexamtimer object to store in customdata
        $fdata = new stdClass();
        $fdata->showexpanded = $folderexamtimer->showexpanded;
        $fdata->showdownloadfolderexamtimer = $folderexamtimer->showdownloadfolderexamtimer;
        $fdata->forcedownload = $folderexamtimer->forcedownload;
        if ($cm->showdescription && strlen(trim($folderexamtimer->intro))) {
            $fdata->intro = $folderexamtimer->intro;
            if ($folderexamtimer->introformat != FORMAT_MOODLE) {
                $fdata->introformat = $folderexamtimer->introformat;
            }
        }


        $cminfo->customdata = $fdata;
    } else {
        if ($cm->showdescription) {
            // Convert intro to html. Do not filter cached version, filters run at display time.
            $fdata->content = format_module_intro('folderexamtimer', $folderexamtimer, $cm->id, false);
        }
    }

        // Populate the custom completion rules as key => value pairs, but only if the completion mode is 'automatic'.
        if ($cm->completion == COMPLETION_TRACKING_AUTOMATIC) {
            $result->customdata['customcompletionrules']['completiondownload'] = $folderexamtimer->completiondownload;

        }

    return $cminfo;
}

/**
 * Sets dynamic information about a course module
 *
 * This function is called from cm_info when displaying the module
 * mod_folderexamtimer can be displayed inline on course page and therefore have no course link
 *
 * @param cm_info $cm
 */
function folderexamtimer_cm_info_dynamic(cm_info $cm) {
    if ($cm->customdata) {
        // the field 'customdata' is not empty IF AND ONLY IF we display contens inline
        $cm->set_no_view_link();
    }
}

/**
 * Overwrites the content in the course-module object with the folderexamtimer files list
 * if folderexamtimer.display == folderexamtimer_DISPLAY_INLINE
 *
 * @param cm_info $cm
 */
function folderexamtimer_cm_info_view(cm_info $cm) {
    global $PAGE;
    if ($cm->uservisible && $cm->customdata &&
            has_capability('mod/folderexamtimer:view', $cm->context)) {
        // Restore folderexamtimer object from customdata.
        // Note the field 'customdata' is not empty IF AND ONLY IF we display contens inline.
        // Otherwise the content is default.
        $folderexamtimer = $cm->customdata;
        $folderexamtimer->id = (int)$cm->instance;
        $folderexamtimer->course = (int)$cm->course;
        $folderexamtimer->display = FOLDEREXAMTIMER_DISPLAY_INLINE;
        $folderexamtimer->name = $cm->name;
        if (empty($folderexamtimer->intro)) {
            $folderexamtimer->intro = '';
        }
        if (empty($folderexamtimer->introformat)) {
            $folderexamtimer->introformat = FORMAT_MOODLE;
        }
        // display folderexamtimer
        $renderer = $PAGE->get_renderer('mod_folderexamtimer');
        $cm->set_content($renderer->display_folderexamtimer($folderexamtimer), true);
    }
}

/**
 * Mark the activity completed (if required) and trigger the course_module_viewed event.
 *
 * @param  stdClass $folderexamtimer     folderexamtimer object
 * @param  stdClass $course     course object
 * @param  stdClass $cm         course module object
 * @param  stdClass $context    context object
 * @since Moodle 3.0
 */
function folderexamtimer_view($folderexamtimer, $course, $cm, $context) {

    // Trigger course_module_viewed event.
    $params = array(
        'context' => $context,
        'objectid' => $folderexamtimer->id
    );

    $event = \mod_folderexamtimer\event\course_module_viewed::create($params);
    $event->add_record_snapshot('course_modules', $cm);
    $event->add_record_snapshot('course', $course);
    $event->add_record_snapshot('folderexamtimer', $folderexamtimer);
    $event->trigger();

    // Completion.
    $completion = new completion_info($course);
    $completion->set_module_viewed($cm);
}

/**
 * Check if the folderexamtimer can be zipped and downloaded.
 * @param stdClass $folderexamtimer
 * @param context_module $cm
 * @return bool True if the folderexamtimer can be zipped and downloaded.
 * @throws \dml_exception
 */
function folderexamtimer_archive_available($folderexamtimer, $cm) {
    if (!$folderexamtimer->showdownloadfolderexamtimer) {
        return false;
    }

    $context = context_module::instance($cm->id);
    $fs = get_file_storage();
    $dir = $fs->get_area_tree($context->id, 'mod_folderexamtimer', 'content', 0);

    $size = folderexamtimer_get_directory_size($dir);
    $maxsize = get_config('folderexamtimer', 'maxsizetodownload') * 1024 * 1024;

    if ($size == 0) {
        return false;
    }

    if (!empty($maxsize) && $size > $maxsize) {
        return false;
    }

    return true;
}

/**
 * Recursively measure the size of the files in a directory.
 * @param array $directory
 * @return int size of directory contents in bytes
 */
function folderexamtimer_get_directory_size($directory) {
    $size = 0;

    foreach ($directory['files'] as $file) {
        $size += $file->get_filesize();
    }

    foreach ($directory['subdirs'] as $subdirectory) {
        $size += folderexamtimer_get_directory_size($subdirectory);
    }

    return $size;
}

/**
 * Mark the activity completed (if required) and trigger the all_files_downloaded event.
 *
 * @param  stdClass $folderexamtimer     folderexamtimer object
 * @param  stdClass $course     course object
 * @param  stdClass $cm         course module object
 * @param  stdClass $context    context object
 * @since Moodle 3.1
 */
function folderexamtimer_downloaded($folderexamtimer, $course, $cm, $context) {
    $params = array(
        'context' => $context,
        'objectid' => $folderexamtimer->id
    );
    $event = \mod_folderexamtimer\event\all_files_downloaded::create($params);
    $event->add_record_snapshot('course_modules', $cm);
    $event->add_record_snapshot('course', $course);
    $event->add_record_snapshot('folderexamtimer', $folderexamtimer);
    $event->trigger();

    // Completion.
    $completion = new completion_info($course);
    $completion->set_module_viewed($cm);
}

/**
 * Returns all uploads since a given time in specified folderexamtimer.
 *
 * @param array $activities
 * @param int $index
 * @param int $timestart
 * @param int $courseid
 * @param int $cmid
 * @param int $userid
 * @param int $groupid not used, but required for compatibilty with other modules
 */
function folderexamtimer_get_recent_mod_activity(&$activities, &$index, $timestart, $courseid, $cmid, $userid=0, $groupid=0) {
    global $COURSE, $DB, $OUTPUT;

    if ($COURSE->id == $courseid) {
        $course = $COURSE;
    } else {
        $course = $DB->get_record('course', array('id' => $courseid));
    }

    $modinfo = get_fast_modinfo($course);
    $cm = $modinfo->cms[$cmid];

    $context = context_module::instance($cm->id);
    if (!has_capability('mod/folderexamtimer:view', $context)) {
        return;
    }
    $files = folderexamtimer_get_recent_activity($context, $timestart, $userid);

    foreach ($files as $file) {
        $tmpactivity = new stdClass();

        $tmpactivity->type       = 'folderexamtimer';
        $tmpactivity->cmid       = $cm->id;
        $tmpactivity->sectionnum = $cm->sectionnum;
        $tmpactivity->timestamp  = $file->get_timemodified();
        $tmpactivity->user       = core_user::get_user($file->get_userid());

        $tmpactivity->content           = new stdClass();
        $tmpactivity->content->url      = moodle_url::make_pluginfile_url($file->get_contextid(), 'mod_folderexamtimer', 'content',
            $file->get_itemid(), $file->get_filepath(), $file->get_filename());

        if (file_extension_in_typegroup($file->get_filename(), 'web_image')) {
            $image = $tmpactivity->content->url->out(false, array('preview' => 'tinyicon', 'oid' => $file->get_timemodified()));
            $image = html_writer::empty_tag('img', array('src' => $image));
        } else {
            $image = $OUTPUT->pix_icon(file_file_icon($file, 24), $file->get_filename(), 'moodle');
        }

        $tmpactivity->content->image    = $image;
        $tmpactivity->content->filename = $file->get_filename();

        $activities[$index++] = $tmpactivity;
    }

}

/**
 * Outputs the folderexamtimer uploads indicated by $activity.
 *
 * @param object $activity      the activity object the folderexamtimer resides in
 * @param int    $courseid      the id of the course the folderexamtimer resides in
 * @param bool   $detail        not used, but required for compatibilty with other modules
 * @param int    $modnames      not used, but required for compatibilty with other modules
 * @param bool   $viewfullnames not used, but required for compatibilty with other modules
 */
function folderexamtimer_print_recent_mod_activity($activity, $courseid, $detail, $modnames, $viewfullnames) {
    global $OUTPUT;

    $content = $activity->content;
    $tableoptions = [
        'border' => '0',
        'cellpadding' => '3',
        'cellspacing' => '0'
    ];
    $output = html_writer::start_tag('table', $tableoptions);
    $output .= html_writer::start_tag('tr');
    $output .= html_writer::tag('td', $content->image, ['class' => 'fp-icon', 'valign' => 'top']);
    $output .= html_writer::start_tag('td');
    $output .= html_writer::start_div('fp-filename');
    $output .= html_writer::link($content->url, $content->filename);
    $output .= html_writer::end_div();

    // Show the uploader.
    $fullname = fullname($activity->user, $viewfullnames);
    $userurl = new moodle_url('/user/view.php');
    $userurl->params(['id' => $activity->user->id, 'course' => $courseid]);
    $by = new stdClass();
    $by->name = html_writer::link($userurl, $fullname);
    $by->date = userdate($activity->timestamp);
    $authornamedate = get_string('bynameondate', 'folderexamtimer', $by);
    $output .= html_writer::div($authornamedate, 'user');

    // Finish up the table.
    $output .= html_writer::end_tag('tr');
    $output .= html_writer::end_tag('table');

    echo $output;
}

/**
 * Gets recent file uploads in a given folderexamtimer. Does not perform security checks.
 *
 * @param object $context
 * @param int $timestart
 * @param int $userid
 *
 * @return array
 */
function folderexamtimer_get_recent_activity($context, $timestart, $userid=0) {
    $newfiles = array();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'mod_folderexamtimer', 'content');
    foreach ($files as $file) {
        if ($file->get_timemodified() <= $timestart) {
            continue;
        }
        if ($file->get_filename() === '.') {
            continue;
        }
        if (!empty($userid) && $userid !== $file->get_userid()) {
            continue;
        }
        $newfiles[] = $file;
    }
    return $newfiles;
}

/**
 * Given a course and a date, prints a summary of all the new
 * files posted in folderexamtimer resources since that date
 *
 * @uses CONTEXT_MODULE
 * @param object $course
 * @param bool $viewfullnames capability
 * @param int $timestart
 * @return bool success
 */
function folderexamtimer_print_recent_activity($course, $viewfullnames, $timestart) {
    global $OUTPUT;

    $folderexamtimers = get_all_instances_in_course('folderexamtimer', $course);

    if (empty($folderexamtimers)) {
        return false;
    }

    $newfiles = array();

    $modinfo = get_fast_modinfo($course);
    foreach ($folderexamtimers as $folderexamtimer) {
        // Skip resources if the user can't view them.
        $cm = $modinfo->cms[$folderexamtimer->coursemodule];
        $context = context_module::instance($cm->id);
        if (!has_capability('mod/folderexamtimer:view', $context)) {
            continue;
        }

        // Get the files uploaded in the current time frame.
        $newfiles = array_merge($newfiles, folderexamtimer_get_recent_activity($context, $timestart));
    }

    if (empty($newfiles)) {
        return false;
    }

    // Build list of files.
    echo $OUTPUT->heading(get_string('newfolderexamtimercontent', 'folderexamtimer') . ':', 6);
    $list = html_writer::start_tag('ul', ['class' => 'unlist']);
    foreach ($newfiles as $file) {
        $filename = $file->get_filename();
        $url = moodle_url::make_pluginfile_url($file->get_contextid(), 'mod_folderexamtimer', 'content',
            $file->get_itemid(), $file->get_filepath(), $filename);

        $list .= html_writer::start_tag('li');
        $list .= html_writer::start_div('head');
        $list .= html_writer::div(userdate($file->get_timemodified(), get_string('strftimerecent')), 'date');
        $list .= html_writer::div($file->get_author(), 'name');
        $list .= html_writer::end_div(); // Head.

        $list .= html_writer::start_div('info');
        $list .= html_writer::link($url, $filename);
        $list .= html_writer::end_div(); // Info.
        $list .= html_writer::end_tag('li');
    }
    $list .= html_writer::end_tag('ul');
    echo $list;
    return true;
}

/**
 * Check if the module has any update that affects the current user since a given time.
 *
 * @param  cm_info $cm course module data
 * @param  int $from the time to check updates from
 * @param  array $filter  if we need to check only specific updates
 * @return stdClass an object with the different type of areas indicating if they were updated or not
 * @since Moodle 3.2
 */
function folderexamtimer_check_updates_since(cm_info $cm, $from, $filter = array()) {
    $updates = course_check_module_updates_since($cm, $from, array('content'), $filter);
    return $updates;
}

/**
 * This function receives a calendar event and returns the action associated with it, or null if there is none.
 *
 * This is used by block_myoverview in order to display the event appropriately. If null is returned then the event
 * is not displayed on the block.
 *
 * @param calendar_event $event
 * @param \core_calendar\action_factory $factory
 * @param int $userid User id to use for all capability checks, etc. Set to 0 for current user (default).
 * @return \core_calendar\local\event\entities\action_interface|null
 */
function mod_folderexamtimer_core_calendar_provide_event_action(calendar_event $event,
                                                       \core_calendar\action_factory $factory,
                                                       int $userid = 0) {
    global $USER;

    if (!$userid) {
        $userid = $USER->id;
    }

    $cm = get_fast_modinfo($event->courseid, $userid)->instances['folderexamtimer'][$event->instance];

    if (!$cm->uservisible) {
        // The module is not visible to the user for any reason.
        return null;
    }

    $completion = new \completion_info($cm->get_course());

    $completiondata = $completion->get_data($cm, false, $userid);

    if ($completiondata->completionstate != COMPLETION_INCOMPLETE) {
        return null;
    }

    return $factory->create_instance(
        get_string('view'),
        new \moodle_url('/mod/folderexamtimer/view.php', ['id' => $cm->id]),
        1,
        true
    );
}

/**
 * Given an array with a file path, it returns the itemid and the filepath for the defined filearea.
 *
 * @param  string $filearea The filearea.
 * @param  array  $args The path (the part after the filearea and before the filename).
 * @return array The itemid and the filepath inside the $args path, for the defined filearea.
 */
function mod_folderexamtimer_get_path_from_pluginfile(string $filearea, array $args) : array {
    // folderexamtimer never has an itemid (the number represents the revision but it's not stored in database).
    array_shift($args);

    // Get the filepath.
    if (empty($args)) {
        $filepath = '/';
    } else {
        $filepath = '/' . implode('/', $args) . '/';
    }

    return [
        'itemid' => 0,
        'filepath' => $filepath,
    ];
}


 /**
  * Obtains the automatic completion state for this forum based on any conditions
  * in forum settings.
  *
  * @param object $course Course
  * @param object $cm Course-module
  * @param int $userid User ID
  * @param bool $type Type of comparison (or/and; can be used as return value if no conditions)
  * @return bool True if completed, false if not, $type if conditions not set.
  */
  function folderexamtimer_get_completion_state($course,$cm,$userid,$type) {
    global $CFG,$DB;

    // Get forum details
    $folderexamtimer = $DB->get_record('folderexamtimer', array('id' => $cm->instance), '*', MUST_EXIST);

    // If completion option is enabled, evaluate it and return true/false
    if($folderexamtimer->completiondownload) {
        return $folderexamtimer->completiondownload;

    } else {
        // Completion option is not enabled so just return $type
        return $type;
    }
}

/**
 * Callback which returns human-readable strings describing the active completion custom rules for the module instance.
 *
 * @param cm_info|stdClass $cm object with fields ->completion and ->customdata['customcompletionrules']
 * @return array $descriptions the array of descriptions for the custom rules.
 */
function mod_folderexamtimer_get_completion_active_rule_descriptions($cm) {
    // Values will be present in cm_info, and we assume these are up to date.
    if (empty($cm->customdata['customcompletionrules'])
        || $cm->completion != COMPLETION_TRACKING_AUTOMATIC) {
        return [];
    }

    $descriptions = [];
    foreach ($cm->customdata['customcompletionrules'] as $key => $val) {
        switch ($key) {
            case 'completiondownload':
                if (!empty($val)) {
                    $descriptions[] = get_string('completiondownloaddesc', 'folderexamtimer', $val);
                }

                break;
            default:
                break;
        }
    }
    return $descriptions;
}
