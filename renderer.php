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
 * @package   Get time
 * @copyleft 2022 Debonair Training {@link http://debonairtraining.com}
 * @copyright 2010 Dongsheng Cai <dongsheng@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class mod_folderexamtimer_renderer extends plugin_renderer_base {

    /** @var string $timenow contains a timestamp in string format. */
    public $timenow;

        public function countdown_timer(exam_attempt $attemptobj, $timenow) {

        $timeleft = $attemptobj->get_time_left_display($timenow);
        if ($timeleft !== false) {
            $ispreview = $attemptobj->is_preview();
            $timerstartvalue = $timeleft;
            if (!$ispreview) {
                // Make sure the timer starts just above zero. If $timeleft was <= 0, then
                // this will just have the effect of causing the exam to be submitted immediately.
                $timerstartvalue = max($timerstartvalue, 1);
            }
            $this->initialise_timer($timerstartvalue, $ispreview);
        }


        return $this->output->render_from_template('mod_folderexamtimer/timer', (object)[]);
    }

    /**
     * Attempt Page
     *
     * @param exam_attempt $attemptobj Instance of exam_attempt
     * @param int $page Current page number
     * @param exam_access_manager $accessmanager Instance of exam_access_manager
     * @param array $messages An array of messages
     * @param array $slots Contains an array of integers that relate to questions
     * @param int $id The ID of an attempt
     * @param int $nextpage The number of the next page
     */


    /**
     * Returns html to display the content of mod_folderexamtimer
     * (Description, folderexamtimer files and optionally Edit button)
     *
     * @param stdClass $folderexamtimer record from 'folderexamtimer' table (please note
     *     it may not contain fields 'revision' and 'timemodified')
     * @return string
     */
    public function display_folderexamtimer(stdClass $folderexamtimer) {
        $output = '';
        $folderexamtimerinstances = get_fast_modinfo($folderexamtimer->course)->get_instances_of('folderexamtimer');
        if (!isset($folderexamtimerinstances[$folderexamtimer->id]) ||
                !($cm = $folderexamtimerinstances[$folderexamtimer->id]) ||
                !($context = context_module::instance($cm->id))) {
            // Some error in parameters.
            // Don't throw any errors in renderer, just return empty string.
            // Capability to view module must be checked before calling renderer.
            return $output;
        }

        if (trim($folderexamtimer->intro)) {
            if ($folderexamtimer->display != FOLDEREXAMTIMER_DISPLAY_INLINE) {
                $output .= $this->output->box(format_module_intro('folderexamtimer', $folderexamtimer, $cm->id),
                        'generalbox', 'intro');
            } else if ($cm->showdescription) {
                // for "display inline" do not filter, filters run at display time.
                $output .= format_module_intro('folderexamtimer', $folderexamtimer, $cm->id, false);
            }
        }

        $folderexamtimertree = new folderexamtimer_tree($folderexamtimer, $cm);
        if ($folderexamtimer->display == FOLDEREXAMTIMER_DISPLAY_INLINE) {
            // Display module name as the name of the root directory.
            $folderexamtimertree->dir['dirname'] = $cm->get_formatted_name(array('escape' => false));
        }


    $context = context_module::instance($cm->id);
    if (has_capability('mod/folderexamtimer:managefiles', $context)) {

//Display files to only logged in user who has capability
        $output .= $this->output->render_from_template('mod_folderexamtimer/timer', (object)[]);

    }else{
        $output .= $this->output->render_from_template('mod_folderexamtimer/timerstudent', (object)[]);

    }

        //$output .= "testing testing";
        $output .= $this->output->container_start("box generalbox pt-0 pb-3 folderexamtimertree");

        $output .= $this->render($folderexamtimertree);
        $output .= $this->output->container_end();

        // Do not append the edit button on the course page.
        $downloadable = folderexamtimer_archive_available($folderexamtimer, $cm);

        $buttons = '';
        if ($downloadable) {
            $downloadbutton = $this->output->single_button(
                new moodle_url('/mod/folderexamtimer/download_folderexamtimer.php', array('id' => $cm->id)),
                get_string('downloadfolderexamtimer', 'folderexamtimer')
            );

            $buttons .= $downloadbutton;
        }

        // Display the "Edit" button if current user can edit folderexamtimer contents.
        // Do not display it on the course page for the teachers because there
        // is an "Edit settings" button right next to it with the same functionality.
        if (has_capability('mod/folderexamtimer:managefiles', $context) &&
            ($folderexamtimer->display != FOLDEREXAMTIMER_DISPLAY_INLINE || !has_capability('moodle/course:manageactivities', $context))) {

                $editbutton = $this->output->single_button(
                new moodle_url('/mod/folderexamtimer/edit.php', array('id' => $cm->id)),
                get_string('edit')
            );

            $buttons .= $editbutton;
        }

      if ($buttons) {
            $output .= '<div id="controlbutton" style="display:none">';
            $output .= $this->output->container_start("box generalbox pt-0 pb-3 folderexamtimerbuttons");
            $output .= $buttons;
            $output .= $this->output->container_end();
            $output .= '</div>';


        }

        return $output;
    }


    public function render_folderexamtimer_tree(folderexamtimer_tree $tree) {
        static $treecounter = 0;

        $content = '';
        $id = 'folderexamtimer_tree'. ($treecounter++);
        $content .= '<div id="'.$id.'" class="filemanager" style="display:none;">';
        $content .= $this->htmllize_tree($tree, array('files' => array(), 'subdirs' => array($tree->dir)));
        $content .= '</div>';
        $showexpanded = true;
        if (empty($tree->folderexamtimer->showexpanded)) {
            $showexpanded = false;
        }
        $this->page->requires->js_init_call('M.mod_folderexamtimer.init_tree', array($id, $showexpanded));
        return $content;
    }




 /**
     * Internal function - creates htmls structure suitable for YUI tree.
     */

    protected function htmllize_tree($tree, $dir) {
        global $CFG;
        global $context;

        global $cm;

        if (empty($dir['subdirs']) and empty($dir['files'])) {
            return '';
        }


// If the user logged in has capability the link will work else the link will be false and reload page
        $context = context_module::instance($cm->id);
        if (has_capability('mod/folderexamtimer:managefiles', $context)) {

             $url=$url;
        }else{

             $url="";
        }
        $result = '<ul>';
        foreach ($dir['subdirs'] as $subdir) {
            $image = $this->output->pix_icon(file_folder_icon(24), $subdir['dirname'], 'moodle');
            $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')).
                    html_writer::tag('span', s($subdir['dirname']), array('class' => 'fp-filename'));
            $filename = html_writer::tag('div', $filename, array('class' => 'fp-filename-icon'));
            $result .= html_writer::tag('li', $filename. $this->htmllize_tree($tree, $subdir));
        }
        foreach ($dir['files'] as $file) {
            $filename = $file->get_filename();
            $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(),
                    $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $filename, false);
            $filenamedisplay = clean_filename($filename);
            if (file_extension_in_typegroup($filename, 'web_image')) {
                $image = $url->out(false, array('preview' => 'tinyicon', 'oid' => $file->get_timemodified()));
                $image = html_writer::empty_tag('img', array('src' => $image));
            } else {
                $image = $this->output->pix_icon(file_file_icon($file, 24), $filenamedisplay, 'moodle');
            }
            $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')).
                    html_writer::tag('span', $filenamedisplay, array('class' => 'fp-filename'));
            $urlparams = null;
            if ($tree->folderexamtimer->forcedownload) {
                $urlparams = ['forcedownload' => 1];
            }


				$filename = html_writer::tag('span',
					html_writer::link($url, $filename),
					['class' => 'fp-filename-icon']
				);

				$result .= html_writer::tag('li', $filename);

        }

        $result .= '</ul>';

        return $result;
    }

}

class folderexamtimer_tree implements renderable {
    public $context;
    public $folderexamtimer;
    public $cm;
    public $dir;

    public function __construct($folderexamtimer, $cm) {
        $this->folderexamtimer = $folderexamtimer;
        $this->cm     = $cm;

        $this->context = context_module::instance($cm->id);
        $fs = get_file_storage();
        $this->dir = $fs->get_area_tree($this->context->id, 'mod_folderexamtimer', 'content', 0);
    }
}
