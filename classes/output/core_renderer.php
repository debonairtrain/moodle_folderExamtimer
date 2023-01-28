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
 * Theme competency - Core renderer
 *
 * @package     theme_competency
 * @copyright   2022 Debonair Training Ltd, debonairtraining.com
 * @author      Debonair Dev Team
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_competency\output;

use html_writer;
use custom_menu;
use stdClass;
use moodle_url;
use context_course;
use theme_config;

class core_renderer extends \theme_boost\output\core_renderer {

    public function headerimage() {
        global $CFG;
        // Get course overview files.
        if (empty($CFG->courseoverviewfileslimit)) {
            return '';
        }
        $fs = get_file_storage();
        $context = context_course::instance($this->page->course->id);
        $files = $fs->get_area_files($context->id, 'course', 'overviewfiles', false, 'filename', false);
        if (count($files)) {
            $overviewfilesoptions = course_overviewfiles_options($this->page->course->id);
            $acceptedtypes = $overviewfilesoptions['accepted_types'];
            if ($acceptedtypes !== '*') {
                foreach ($files as $key => $file) {
                    if (!file_extension_in_typegroup($file->get_filename() , $acceptedtypes)) {
                        unset($files[$key]);
                    }
                }
            }
            if (count($files) > $CFG->courseoverviewfileslimit) {
                // Return no more than $CFG->courseoverviewfileslimit files.
                $files = array_slice($files, 0, $CFG->courseoverviewfileslimit, true);
            }
        }
        // Get course overview files as images - set $courseimage.
        // The loop means that the LAST stored image will be the one displayed if >1 image file.
        $courseimage = '';
        foreach ($files as $file) {
            $isimage = $file->is_valid_image();
            if ($isimage) {
                $courseimage = file_encode_url("$CFG->wwwroot/pluginfile.php", '/' . $file->get_contextid() . '/' . $file->get_component() . '/' . $file->get_filearea() . $file->get_filepath() . $file->get_filename() , !$isimage);
            }
        }
        $html = '';
        $headerbg = $this->page->theme->setting_file_url('pagebackgroundimage', 'pagebackgroundimage');
        $defaultimgurl = $this->image_url('headerbg', 'theme');
        $headerbgimgurl = $this->page->theme->setting_file_url('headerdefaultimage', 'headerdefaultimage', true);
        // Create html for header.
        if ($this->page->theme->settings->showheaderblockpanel){
            $html = html_writer::start_div('headerbkg');
            // If course image display it in separate div to allow css styling of inline style.
            if ($this->page->theme->settings->showpageimage == 1 && $courseimage && !$this->page->theme->settings->sitewideimage == 1) {
                $html .= html_writer::start_div('courseimage', array(
                    'style' => 'background-image: url("' . $courseimage . '"); background-size: cover; background-position:center;
                    width: 100%; height: 100%;'
                ));
                $html .= html_writer::end_div(); // End withimage inline style div.
            }
            else if ($this->page->theme->settings->showpageimage == 1 && isset($headerbg)) {
                $html .= html_writer::start_div('customimage', array(
                    'style' => 'background-image: url("' . $headerbgimgurl . '"); background-size: cover; background-position:center;
                    width: 100%; height: 100%;'
                ));
                $html .= html_writer::end_div(); // End withoutimage inline style div.

            }
            else {
                $html .= html_writer::start_div('defaultheaderimage', array(
                    'style' => 'background-image: url("' . $defaultimgurl . '"); background-size: cover; background-position:center;
                    width: 100%; height: 100%;'
                ));
                $html .= html_writer::end_div(); // End default inline style div.
            }
            $html .= html_writer::end_div();
        }
        return $html;
    }

    /**
     * Wrapper for header elements.
     *
     * @return string HTML to display the main header.
     */
    public function full_header() {
        $pagetype = $this->page->pagetype;
        $homepage = get_home_page();
        $homepagetype = null;
        $mycourses = get_string('latestcourses', 'theme_competency');
        $mycoursesurl = new moodle_url('/my/');
        $mycoursesmenu = $this->competency_mycourses();
        $hasmycourses = $this->page->pagelayout == 'course';

        // Add a special case since /my/courses is a part of the /my subsystem.
        if ($homepage == HOMEPAGE_MY || $homepage == HOMEPAGE_MYCOURSES) {
            $homepagetype = 'my-index';
        } else if ($homepage == HOMEPAGE_SITE) {
            $homepagetype = 'site-index';
        }
        if ($this->page->include_region_main_settings_in_header_actions() &&
                !$this->page->blocks->is_block_present('settings')) {
            // Only include the region main settings if the page has requested it and it doesn't already have
            // the settings block on it. The region main settings are included in the settings block and
            // duplicating the content causes behat failures.
            $this->page->add_header_action(html_writer::div(
                $this->region_main_settings_menu(),
                'd-print-none',
                ['id' => 'region-main-settings-menu']
            ));
        }
        $header = new stdClass();
        $header->settingsmenu = $this->context_header_settings_menu();
        $header->contextheader = $this->context_header();
        $header->hasnavbar = empty($this->page->layout_options['nonavbar']);
        $header->navbar = $this->navbar();
        $header->hasmycourses = $hasmycourses;
        $header->mycourses = $mycourses;
        $header->mycoursesmenu = $mycoursesmenu;
        $header->pageheadingbutton = $this->page_heading_button();
        $header->courseheader = $this->course_header();
        $header->headeractions = $this->page->get_header_actions();
        if (!empty($pagetype) && !empty($homepagetype) && $pagetype == $homepagetype) {
            $header->welcomemessage = \core_user::welcome_message();
        }
        return $this->render_from_template('theme_competency/core/full_header', $header);
    }

    /**
     * Returns standard navigation between activities in a course.
     *
     * @return string the navigation HTML.
     */
    public function top_activity_navigation() {
        // First we should check if we want to add navigation.
        $context = $this->page->context;
        if (($this->page->pagelayout !== 'incourse' && $this->page->pagelayout !== 'frametop')
            || $context->contextlevel != CONTEXT_MODULE) {
            return '';
        }
        // If the activity is in stealth mode, show no links.
        if ($this->page->cm->is_stealth()) {
            return '';
        }
        $course = $this->page->cm->get_course();
        $courseformat = course_get_format($course);
        // If the theme implements course index and the current course format uses course index and the current
        // page layout is not 'frametop' (this layout does not support course index), show no links.
        if ($this->page->theme->settings->activitynavdisplay ==2 || $this->page->theme->settings->activitynavdisplay ==4 ) {
                return '';
        }
        // Get a list of all the activities in the course.
        $modules = get_fast_modinfo($course->id)->get_cms();
        // Put the modules into an array in order by the position they are shown in the course.
        $mods = [];
        $activitylist = [];
        foreach ($modules as $module) {
            // Only add activities the user can access, aren't in stealth mode and have a url (eg. mod_label does not).
            if (!$module->uservisible || $module->is_stealth() || empty($module->url)) {
                continue;
            }
            $mods[$module->id] = $module;

            // No need to add the current module to the list for the activity dropdown menu.
            if ($module->id == $this->page->cm->id) {
                continue;
            }
            // Module name.
            $modname = $module->get_formatted_name();
            // Display the hidden text if necessary.
            if (!$module->visible) {
                $modname .= ' ' . get_string('hiddenwithbrackets');
            }
            // Module URL.
            $linkurl = new moodle_url($module->url, array('forceview' => 1));
            // Add module URL (as key) and name (as value) to the activity list array.
            $activitylist[$linkurl->out(false)] = $modname;
        }
        $nummods = count($mods);
        // If there is only one mod then do nothing.
        if ($nummods == 1) {
            return '';
        }
        // Get an array of just the course module ids used to get the cmid value based on their position in the course.
        $modids = array_keys($mods);
        // Get the position in the array of the course module we are viewing.
        $position = array_search($this->page->cm->id, $modids);
        $prevmod = null;
        $nextmod = null;
        // Check if we have a previous mod to show.
        if ($position > 0) {
            $prevmod = $mods[$modids[$position - 1]];
        }
        // Check if we have a next mod to show.
        if ($position < ($nummods - 1)) {
            $nextmod = $mods[$modids[$position + 1]];
        }
        $activitynav = new \core_course\output\activity_navigation($prevmod, $nextmod);
        $renderer = $this->page->get_renderer('core', 'course');
        return $renderer->render_from_template('theme_competency/core_course/top_activity_navigation', $activitynav);
    }

    /**
     * Returns standard navigation between activities in a course.
     *
     * @return string the navigation HTML.
     */
    public function activity_navigation() {
        // First we should check if we want to add navigation.
        $context = $this->page->context;
        if (($this->page->pagelayout !== 'incourse' && $this->page->pagelayout !== 'frametop')
            || $context->contextlevel != CONTEXT_MODULE) {
            return '';
        }
        // If the activity is in stealth mode, show no links.
        if ($this->page->cm->is_stealth()) {
            return '';
        }
        $course = $this->page->cm->get_course();
        $courseformat = course_get_format($course);
        // If the theme implements course index and the current course format uses course index and the current
        // page layout is not 'frametop' (this layout does not support course index), show no links.
        if ($this->page->theme->settings->activitynavdisplay ==1 || $this->page->theme->settings->activitynavdisplay ==4 ) {
                return '';
        }
        // Get a list of all the activities in the course.
        $modules = get_fast_modinfo($course->id)->get_cms();
        // Put the modules into an array in order by the position they are shown in the course.
        $mods = [];
        $activitylist = [];
        foreach ($modules as $module) {
            // Only add activities the user can access, aren't in stealth mode and have a url (eg. mod_label does not).
            if (!$module->uservisible || $module->is_stealth() || empty($module->url)) {
                continue;
            }
            $mods[$module->id] = $module;
            // No need to add the current module to the list for the activity dropdown menu.
            if ($module->id == $this->page->cm->id) {
                continue;
            }
            // Module name.
            $modname = $module->get_formatted_name();
            // Display the hidden text if necessary.
            if (!$module->visible) {
                $modname .= ' ' . get_string('hiddenwithbrackets');
            }
            // Module URL.
            $linkurl = new moodle_url($module->url, array('forceview' => 1));
            // Add module URL (as key) and name (as value) to the activity list array.
            $activitylist[$linkurl->out(false)] = $modname;
        }
        $nummods = count($mods);
        // If there is only one mod then do nothing.
        if ($nummods == 1) {
            return '';
        }
        // Get an array of just the course module ids used to get the cmid value based on their position in the course.
        $modids = array_keys($mods);
        // Get the position in the array of the course module we are viewing.
        $position = array_search($this->page->cm->id, $modids);
        $prevmod = null;
        $nextmod = null;
        // Check if we have a previous mod to show.
        if ($position > 0) {
            $prevmod = $mods[$modids[$position - 1]];
        }
        // Check if we have a next mod to show.
        if ($position < ($nummods - 1)) {
            $nextmod = $mods[$modids[$position + 1]];
        }
        $activitynav = new \core_course\output\activity_navigation($prevmod, $nextmod, $activitylist);
        $renderer = $this->page->get_renderer('core', 'course');
        return $renderer->render($activitynav);
    }


         public function fp_wonderbox() {
           global $PAGE;
           $context = $this->page->context;
           $hascreateicon = (empty($PAGE->theme->settings->createicon && isloggedin() && has_capability('moodle/course:create', $context))) ? false : $PAGE->theme->settings->createicon;
           $createbuttonurl = (empty($PAGE->theme->settings->createbuttonurl)) ? false : $PAGE->theme->settings->createbuttonurl;
           $createbuttontext = (empty($PAGE->theme->settings->createbuttontext)) ? false : format_string($PAGE->theme->settings->createbuttontext);
           $hasslideicon = (empty($PAGE->theme->settings->slideicon && isloggedin() && !isguestuser())) ? false : $PAGE->theme->settings->slideicon;
           $slideiconbuttonurl = 'data-toggle="collapse" data-target="#collapseExample';
           $slideiconbuttontext = (empty($PAGE->theme->settings->slideiconbuttontext)) ? false : format_string($PAGE->theme->settings->slideiconbuttontext);
           $hasnav1icon = (empty($PAGE->theme->settings->nav1icon && isloggedin() && !isguestuser())) ? false : $PAGE->theme->settings->nav1icon;
           $hasnav2icon = (empty($PAGE->theme->settings->nav2icon && isloggedin() && !isguestuser())) ? false : $PAGE->theme->settings->nav2icon;
           $hasnav3icon = (empty($PAGE->theme->settings->nav3icon && isloggedin() && !isguestuser())) ? false : $PAGE->theme->settings->nav3icon;
           $hasnav4icon = (empty($PAGE->theme->settings->nav4icon && isloggedin() && !isguestuser())) ? false : $PAGE->theme->settings->nav4icon;
           $hasnav5icon = (empty($PAGE->theme->settings->nav5icon && isloggedin() && !isguestuser())) ? false : $PAGE->theme->settings->nav5icon;
           $hasnav6icon = (empty($PAGE->theme->settings->nav6icon && isloggedin() && !isguestuser())) ? false : $PAGE->theme->settings->nav6icon;
           $hasnav7icon = (empty($PAGE->theme->settings->nav7icon && isloggedin() && !isguestuser())) ? false : $PAGE->theme->settings->nav7icon;
           $hasnav8icon = (empty($PAGE->theme->settings->nav8icon && isloggedin() && !isguestuser())) ? false : $PAGE->theme->settings->nav8icon;
           $nav1buttonurl = (empty($PAGE->theme->settings->nav1buttonurl)) ? false : $PAGE->theme->settings->nav1buttonurl;
           $nav2buttonurl = (empty($PAGE->theme->settings->nav2buttonurl)) ? false : $PAGE->theme->settings->nav2buttonurl;
           $nav3buttonurl = (empty($PAGE->theme->settings->nav3buttonurl)) ? false : $PAGE->theme->settings->nav3buttonurl;
           $nav4buttonurl = (empty($PAGE->theme->settings->nav4buttonurl)) ? false : $PAGE->theme->settings->nav4buttonurl;
           $nav5buttonurl = (empty($PAGE->theme->settings->nav5buttonurl)) ? false : $PAGE->theme->settings->nav5buttonurl;
           $nav6buttonurl = (empty($PAGE->theme->settings->nav6buttonurl)) ? false : $PAGE->theme->settings->nav6buttonurl;
           $nav7buttonurl = (empty($PAGE->theme->settings->nav7buttonurl)) ? false : $PAGE->theme->settings->nav7buttonurl;
           $nav8buttonurl = (empty($PAGE->theme->settings->nav8buttonurl)) ? false : $PAGE->theme->settings->nav8buttonurl;
           $nav1buttontext = (empty($PAGE->theme->settings->nav1buttontext)) ? false : format_string($PAGE->theme->settings->nav1buttontext);
           $nav2buttontext = (empty($PAGE->theme->settings->nav2buttontext)) ? false : format_string($PAGE->theme->settings->nav2buttontext);
           $nav3buttontext = (empty($PAGE->theme->settings->nav3buttontext)) ? false : format_string($PAGE->theme->settings->nav3buttontext);
           $nav4buttontext = (empty($PAGE->theme->settings->nav4buttontext)) ? false : format_string($PAGE->theme->settings->nav4buttontext);
           $nav5buttontext = (empty($PAGE->theme->settings->nav5buttontext)) ? false : format_string($PAGE->theme->settings->nav5buttontext);
           $nav6buttontext = (empty($PAGE->theme->settings->nav6buttontext)) ? false : format_string($PAGE->theme->settings->nav6buttontext);
           $nav7buttontext = (empty($PAGE->theme->settings->nav7buttontext)) ? false : format_string($PAGE->theme->settings->nav7buttontext);
           $nav8buttontext = (empty($PAGE->theme->settings->nav8buttontext)) ? false : format_string($PAGE->theme->settings->nav8buttontext);
           $nav1target = (empty($PAGE->theme->settings->nav1target)) ? false : $PAGE->theme->settings->nav1target;
           $nav2target = (empty($PAGE->theme->settings->nav2target)) ? false : $PAGE->theme->settings->nav2target;
           $nav3target = (empty($PAGE->theme->settings->nav3target)) ? false : $PAGE->theme->settings->nav3target;
           $nav4target = (empty($PAGE->theme->settings->nav4target)) ? false : $PAGE->theme->settings->nav4target;
           $nav5target = (empty($PAGE->theme->settings->nav5target)) ? false : $PAGE->theme->settings->nav5target;
           $nav6target = (empty($PAGE->theme->settings->nav6target)) ? false : $PAGE->theme->settings->nav6target;
           $nav7target = (empty($PAGE->theme->settings->nav7target)) ? false : $PAGE->theme->settings->nav7target;
           $nav8target = (empty($PAGE->theme->settings->nav8target)) ? false : $PAGE->theme->settings->nav8target;
           $fptextbox = (empty($PAGE->theme->settings->fptextbox && isloggedin())) ? false : format_text($PAGE->theme->settings->fptextbox, FORMAT_HTML, array(
               'noclean' => true
           ));
           $fptextboxlogout = (empty($PAGE->theme->settings->fptextboxlogout && !isloggedin())) ? false : format_text($PAGE->theme->settings->fptextboxlogout, FORMAT_HTML, array(
               'noclean' => true
           ));
           $slidetextbox = (empty($PAGE->theme->settings->slidetextbox && isloggedin())) ? false : format_text($PAGE->theme->settings->slidetextbox, FORMAT_HTML, array(
               'noclean' => true
           ));
           $alertbox = (empty($PAGE->theme->settings->alertbox)) ? false : format_text($PAGE->theme->settings->alertbox, FORMAT_HTML, array(
               'noclean' => true
           ));

           $hasmarketing1 = (empty($PAGE->theme->settings->marketing1 && $PAGE->theme->settings->togglemarketing == 1)) ? false : format_string($PAGE->theme->settings->marketing1);
           $marketing1content = (empty($PAGE->theme->settings->marketing1content)) ? false : format_text($PAGE->theme->settings->marketing1content);
           $marketing1buttontext = (empty($PAGE->theme->settings->marketing1buttontext)) ? false : format_string($PAGE->theme->settings->marketing1buttontext);
           $marketing1buttonurl = (empty($PAGE->theme->settings->marketing1buttonurl)) ? false : $PAGE->theme->settings->marketing1buttonurl;
           $marketing1target = (empty($PAGE->theme->settings->marketing1target)) ? false : $PAGE->theme->settings->marketing1target;
           $marketing1image = (empty($PAGE->theme->settings->marketing1image)) ? false : 'marketing1image';

           $hasmarketing2 = (empty($PAGE->theme->settings->marketing2 && $PAGE->theme->settings->togglemarketing == 1)) ? false : format_string($PAGE->theme->settings->marketing2);
           $marketing2content = (empty($PAGE->theme->settings->marketing2content)) ? false : format_text($PAGE->theme->settings->marketing2content);
           $marketing2buttontext = (empty($PAGE->theme->settings->marketing2buttontext)) ? false : format_string($PAGE->theme->settings->marketing2buttontext);
           $marketing2buttonurl = (empty($PAGE->theme->settings->marketing2buttonurl)) ? false : $PAGE->theme->settings->marketing2buttonurl;
           $marketing2target = (empty($PAGE->theme->settings->marketing2target)) ? false : $PAGE->theme->settings->marketing2target;
           $marketing2image = (empty($PAGE->theme->settings->marketing2image)) ? false : 'marketing2image';

           $hasmarketing3 = (empty($PAGE->theme->settings->marketing3 && $PAGE->theme->settings->togglemarketing == 1)) ? false : format_string($PAGE->theme->settings->marketing3);
           $marketing3content = (empty($PAGE->theme->settings->marketing3content)) ? false : format_text($PAGE->theme->settings->marketing3content);
           $marketing3buttontext = (empty($PAGE->theme->settings->marketing3buttontext)) ? false : format_string($PAGE->theme->settings->marketing3buttontext);
           $marketing3buttonurl = (empty($PAGE->theme->settings->marketing3buttonurl)) ? false : $PAGE->theme->settings->marketing3buttonurl;
           $marketing3target = (empty($PAGE->theme->settings->marketing3target)) ? false : $PAGE->theme->settings->marketing3target;
           $marketing3image = (empty($PAGE->theme->settings->marketing3image)) ? false : 'marketing3image';

           $hasmarketing4 = (empty($PAGE->theme->settings->marketing4 && $PAGE->theme->settings->togglemarketing == 1)) ? false : format_string($PAGE->theme->settings->marketing4);
           $marketing4content = (empty($PAGE->theme->settings->marketing4content)) ? false : format_text($PAGE->theme->settings->marketing4content);
           $marketing4buttontext = (empty($PAGE->theme->settings->marketing4buttontext)) ? false : format_string($PAGE->theme->settings->marketing4buttontext);
           $marketing4buttonurl = (empty($PAGE->theme->settings->marketing4buttonurl)) ? false : $PAGE->theme->settings->marketing4buttonurl;
           $marketing4target = (empty($PAGE->theme->settings->marketing4target)) ? false : $PAGE->theme->settings->marketing4target;
           $marketing4image = (empty($PAGE->theme->settings->marketing4image)) ? false : 'marketing4image';

           $hasmarketing5 = (empty($PAGE->theme->settings->marketing5 && $PAGE->theme->settings->togglemarketing == 1)) ? false : format_string($PAGE->theme->settings->marketing5);
           $marketing5content = (empty($PAGE->theme->settings->marketing5content)) ? false : format_text($PAGE->theme->settings->marketing5content);
           $marketing5buttontext = (empty($PAGE->theme->settings->marketing5buttontext)) ? false : format_string($PAGE->theme->settings->marketing5buttontext);
           $marketing5buttonurl = (empty($PAGE->theme->settings->marketing5buttonurl)) ? false : $PAGE->theme->settings->marketing5buttonurl;
           $marketing5target = (empty($PAGE->theme->settings->marketing5target)) ? false : $PAGE->theme->settings->marketing5target;
           $marketing5image = (empty($PAGE->theme->settings->marketing5image)) ? false : 'marketing5image';

           $hasmarketing6 = (empty($PAGE->theme->settings->marketing6 && $PAGE->theme->settings->togglemarketing == 1)) ? false : format_string($PAGE->theme->settings->marketing6);
           $marketing6content = (empty($PAGE->theme->settings->marketing6content)) ? false : format_text($PAGE->theme->settings->marketing6content);
           $marketing6buttontext = (empty($PAGE->theme->settings->marketing6buttontext)) ? false : format_string($PAGE->theme->settings->marketing6buttontext);
           $marketing6buttonurl = (empty($PAGE->theme->settings->marketing6buttonurl)) ? false : $PAGE->theme->settings->marketing6buttonurl;
           $marketing6target = (empty($PAGE->theme->settings->marketing6target)) ? false : $PAGE->theme->settings->marketing6target;
           $marketing6image = (empty($PAGE->theme->settings->marketing6image)) ? false : 'marketing6image';

           $hasmarketing7 = (empty($PAGE->theme->settings->marketing7 && $PAGE->theme->settings->togglemarketing == 1)) ? false : format_string($PAGE->theme->settings->marketing7);
           $marketing7content = (empty($PAGE->theme->settings->marketing7content)) ? false : format_text($PAGE->theme->settings->marketing7content);
           $marketing7buttontext = (empty($PAGE->theme->settings->marketing7buttontext)) ? false : format_string($PAGE->theme->settings->marketing7buttontext);
           $marketing7buttonurl = (empty($PAGE->theme->settings->marketing7buttonurl)) ? false : $PAGE->theme->settings->marketing7buttonurl;
           $marketing7target = (empty($PAGE->theme->settings->marketing7target)) ? false : $PAGE->theme->settings->marketing7target;
           $marketing7image = (empty($PAGE->theme->settings->marketing7image)) ? false : 'marketing7image';

           $hasmarketing8 = (empty($PAGE->theme->settings->marketing8 && $PAGE->theme->settings->togglemarketing == 1)) ? false : format_string($PAGE->theme->settings->marketing8);
           $marketing8content = (empty($PAGE->theme->settings->marketing8content)) ? false : format_text($PAGE->theme->settings->marketing8content);
           $marketing8buttontext = (empty($PAGE->theme->settings->marketing8buttontext)) ? false : format_string($PAGE->theme->settings->marketing8buttontext);
           $marketing8buttonurl = (empty($PAGE->theme->settings->marketing8buttonurl)) ? false : $PAGE->theme->settings->marketing8buttonurl;
           $marketing8target = (empty($PAGE->theme->settings->marketing8target)) ? false : $PAGE->theme->settings->marketing8target;
           $marketing8image = (empty($PAGE->theme->settings->marketing8image)) ? false : 'marketing8image';

           $hasmarketing9 = (empty($PAGE->theme->settings->marketing9 && $PAGE->theme->settings->togglemarketing == 1)) ? false : format_string($PAGE->theme->settings->marketing9);
           $marketing9content = (empty($PAGE->theme->settings->marketing9content)) ? false : format_text($PAGE->theme->settings->marketing9content);
           $marketing9buttontext = (empty($PAGE->theme->settings->marketing9buttontext)) ? false : format_string($PAGE->theme->settings->marketing9buttontext);
           $marketing9buttonurl = (empty($PAGE->theme->settings->marketing9buttonurl)) ? false : $PAGE->theme->settings->marketing9buttonurl;
           $marketing9target = (empty($PAGE->theme->settings->marketing9target)) ? false : $PAGE->theme->settings->marketing9target;
           $marketing9image = (empty($PAGE->theme->settings->marketing9image)) ? false : 'marketing9image';
           /*if (method_exists(new \core\session\manager, 'get_login_token')) {
               $logintoken = \core\session\manager::get_login_token();
           } else {
               $logintoken = false;
           }*/
           /*if( method_exists ( "\core\session\manager", "get_login_token" ) ){
               $logintoken = s(\core\session\manager::get_login_token());
               echo '<input type="hidden" name="logintoken" value="' . $logintoken . '" />';
           } else {
               $logintoken = false;
           }*/

           $hascategory1 = (empty($PAGE->theme->settings->category1 && $PAGE->theme->settings->togglecategory == 1)) ? false : format_string($PAGE->theme->settings->category1);
           $category1content = (empty($PAGE->theme->settings->category1content)) ? false : format_text($PAGE->theme->settings->category1content);
           $category1buttontext = (empty($PAGE->theme->settings->category1buttontext)) ? false : format_string($PAGE->theme->settings->category1buttontext);
           $category1buttonurl = (empty($PAGE->theme->settings->category1buttonurl)) ? false : $PAGE->theme->settings->category1buttonurl;
           $category1target = (empty($PAGE->theme->settings->category1target)) ? false : $PAGE->theme->settings->category1target;
           $category1image = (empty($PAGE->theme->settings->category1image)) ? false : $PAGE->theme->setting_file_url('category1image','category1image');

           $hascategory2 = (empty($PAGE->theme->settings->category2 && $PAGE->theme->settings->togglecategory == 1)) ? false : format_string($PAGE->theme->settings->category2);
           $category2content = (empty($PAGE->theme->settings->category2content)) ? false : format_text($PAGE->theme->settings->category2content);
           $category2buttontext = (empty($PAGE->theme->settings->category2buttontext)) ? false : format_string($PAGE->theme->settings->category2buttontext);
           $category2buttonurl = (empty($PAGE->theme->settings->category2buttonurl)) ? false : $PAGE->theme->settings->category2buttonurl;
           $category2target = (empty($PAGE->theme->settings->category2target)) ? false : $PAGE->theme->settings->category2target;
           $category2image = (empty($PAGE->theme->settings->category2image)) ? false : $PAGE->theme->setting_file_url('category2image','category2image');

           $hascategory3 = (empty($PAGE->theme->settings->category3 && $PAGE->theme->settings->togglecategory == 1)) ? false : format_string($PAGE->theme->settings->category3);
           $category3content = (empty($PAGE->theme->settings->category3content)) ? false : format_text($PAGE->theme->settings->category3content);
           $category3buttontext = (empty($PAGE->theme->settings->category3buttontext)) ? false : format_string($PAGE->theme->settings->category3buttontext);
           $category3buttonurl = (empty($PAGE->theme->settings->category3buttonurl)) ? false : $PAGE->theme->settings->category3buttonurl;
           $category3target = (empty($PAGE->theme->settings->category3target)) ? false : $PAGE->theme->settings->category3target;
           $category3image = (empty($PAGE->theme->settings->category3image)) ? false : $PAGE->theme->setting_file_url('category3image','category3image');

           $hascategory4 = (empty($PAGE->theme->settings->category4 && $PAGE->theme->settings->togglecategory == 1)) ? false : format_string($PAGE->theme->settings->category4);
           $category4content = (empty($PAGE->theme->settings->category4content)) ? false : format_text($PAGE->theme->settings->category4content);
           $category4buttontext = (empty($PAGE->theme->settings->category4buttontext)) ? false : format_string($PAGE->theme->settings->category4buttontext);
           $category4buttonurl = (empty($PAGE->theme->settings->category4buttonurl)) ? false : $PAGE->theme->settings->category4buttonurl;
           $category4target = (empty($PAGE->theme->settings->category4target)) ? false : $PAGE->theme->settings->category4target;
           // $category4image = (empty($PAGE->theme->settings->category4image)) ? false : 'category4image';
           $category4image = (empty($PAGE->theme->settings->category4image)) ? false : $PAGE->theme->setting_file_url('category4image','category4image');

           $logintoken = \core\session\manager::get_login_token();

           $fp_wonderboxcontext = ['logintoken' => $logintoken, 'hasfptextbox' => (!empty($PAGE->theme->settings->fptextbox && isloggedin())) , 'fptextbox' => $fptextbox, 'hasslidetextbox' => (!empty($PAGE->theme->settings->slidetextbox && isloggedin())) , 'slidetextbox' => $slidetextbox, 'hasfptextboxlogout' => !isloggedin() , 'fptextboxlogout' => $fptextboxlogout, 'hasshowloginform' => $PAGE->theme->settings->showloginform, 'alertbox' => $alertbox, 'hasmarkettiles' => ($hasmarketing1 || $hasmarketing2 || $hasmarketing3 || $hasmarketing4 || $hasmarketing5 || $hasmarketing6) ? true : false, 'markettiles' => array(
               array(
                   'hastile' => $hasmarketing1,
                   'tileimage' => $marketing1image,
                   'content' => $marketing1content,
                   'title' => $hasmarketing1,
                   'button' => "<a href = '$marketing1buttonurl' title = '$marketing1buttontext' alt='$marketing1buttontext' class='btn btn-primary' target='$marketing1target'> $marketing1buttontext </a>"
               ) ,
               array(
                   'hastile' => $hasmarketing2,
                   'tileimage' => $marketing2image,
                   'content' => $marketing2content,
                   'title' => $hasmarketing2,
                   'button' => "<a href = '$marketing2buttonurl' title = '$marketing2buttontext' alt='$marketing2buttontext' class='btn btn-primary' target='$marketing2target'> $marketing2buttontext </a>"
               ) ,
               array(
                   'hastile' => $hasmarketing3,
                   'tileimage' => $marketing3image,
                   'content' => $marketing3content,
                   'title' => $hasmarketing3,
                   'button' => "<a href = '$marketing3buttonurl' title = '$marketing3buttontext' alt='$marketing3buttontext' class='btn btn-primary' target='$marketing3target'> $marketing3buttontext </a>"
               ) ,
               array(
                   'hastile' => $hasmarketing4,
                   'tileimage' => $marketing4image,
                   'content' => $marketing4content,
                   'title' => $hasmarketing4,
                   'button' => "<a href = '$marketing4buttonurl' title = '$marketing4buttontext' alt='$marketing4buttontext' class='btn btn-primary' target='$marketing4target'> $marketing4buttontext </a>"
               ) ,
               array(
                   'hastile' => $hasmarketing5,
                   'tileimage' => $marketing5image,
                   'content' => $marketing5content,
                   'title' => $hasmarketing5,
                   'button' => "<a href = '$marketing5buttonurl' title = '$marketing5buttontext' alt='$marketing5buttontext' class='btn btn-primary' target='$marketing5target'> $marketing5buttontext </a>"
               ) ,
               array(
                   'hastile' => $hasmarketing6,
                   'tileimage' => $marketing6image,
                   'content' => $marketing6content,
                   'title' => $hasmarketing6,
                   'button' => "<a href = '$marketing6buttonurl' title = '$marketing6buttontext' alt='$marketing6buttontext' class='btn btn-primary' target='$marketing6target'> $marketing6buttontext </a>"
               ) ,
               array(
                   'hastile' => $hasmarketing7,
                   'tileimage' => $marketing7image,
                   'content' => $marketing7content,
                   'title' => $hasmarketing7,
                   'button' => "<a href = '$marketing7buttonurl' title = '$marketing7buttontext' alt='$marketing7buttontext' class='btn btn-primary' target='$marketing7target'> $marketing7buttontext </a>"
               ) ,
               array(
                   'hastile' => $hasmarketing8,
                   'tileimage' => $marketing8image,
                   'content' => $marketing8content,
                   'title' => $hasmarketing8,
                   'button' => "<a href = '$marketing8buttonurl' title = '$marketing8buttontext' alt='$marketing8buttontext' class='btn btn-primary' target='$marketing8target'> $marketing8buttontext </a>"
               ) ,
               array(
                   'hastile' => $hasmarketing9,
                   'tileimage' => $marketing9image,
                   'content' => $marketing9content,
                   'title' => $hasmarketing9,
                   'button' => "<a href = '$marketing9buttonurl' title = '$marketing9buttontext' alt='$marketing9buttontext' class='btn btn-primary' target='$marketing9target'> $marketing9buttontext </a>"
               ) ,
           ) ,

           //for category tiles ? true : false, 'markettiles' => array(
           'hascategory' => ($hascategory1 || $hascategory2 || $hascategory3 || $hascategory4) ? true : false, 'categorytiles' => array(
               array(
                 'hastile' => $hascategory1,
                 'cate_image' => $category1image,
                 'cate_content' => $category1content,
                 'cate_title' => $hascategory1,
                 'cate_button' => "<a href = '$category1buttonurl' title = '$category1buttontext' alt='$category1buttontext' class='btn btn-primary' target='$category1target'> $category1buttontext </a>"
               ) ,
               array(
                 'hastile' => $hascategory2,
                 'cate_image' => $category2image,
                 'cate_content' => $category2content,
                 'cate_title' => $hascategory2,
                 'cate_button' => "<a href = '$category2buttonurl' title = '$category2buttontext' alt='$category2buttontext' class='btn btn-primary' target='$category2target'> $category2buttontext </a>"
                 ) ,
               array(
                 'hastile' => $hascategory3,
                 'cate_image' => $category3image,
                 'cate_content' => $category3content,
                 'cate_title' => $hascategory3,
                 'cate_button' => "<a href = '$category3buttonurl' title = '$category3buttontext' alt='$category3buttontext' class='btn btn-primary' target='$category3target'> $category3buttontext </a>"
                 ) ,
               array(
                 'hastile' => $hascategory4,
                 'cate_image' => $category4image,
                 'cate_content' => $category4content,
                 'cate_title' => $hascategory4,
                 'cate_button' => "<a href = '$category4buttonurl' title = '$category4buttontext' alt='$category4buttontext' class='btn btn-primary' target='$category4target'> $category4buttontext </a>"
               ) ,
             ),
           // If any of the above social networks are true, sets this to true.
           'hasfpiconnav' => ($hasnav1icon || $hasnav2icon || $hasnav3icon || $hasnav4icon || $hasnav5icon || $hasnav6icon || $hasnav7icon || $hasnav8icon || $hascreateicon || $hasslideicon) ? true : false, 'fpiconnav' => array(
               array(
                   'hasicon' => $hasnav1icon,
                   'linkicon' => $hasnav1icon,
                   'link' => $nav1buttonurl,
                   'linktext' => $nav1buttontext,
                   'linktarget' => $nav1target
               ) ,
               array(
                   'hasicon' => $hasnav2icon,
                   'linkicon' => $hasnav2icon,
                   'link' => $nav2buttonurl,
                   'linktext' => $nav2buttontext,
                   'linktarget' => $nav2target
               ) ,
               array(
                   'hasicon' => $hasnav3icon,
                   'linkicon' => $hasnav3icon,
                   'link' => $nav3buttonurl,
                   'linktext' => $nav3buttontext,
                   'linktarget' => $nav3target
               ) ,
               array(
                   'hasicon' => $hasnav4icon,
                   'linkicon' => $hasnav4icon,
                   'link' => $nav4buttonurl,
                   'linktext' => $nav4buttontext,
                   'linktarget' => $nav4target
               ) ,
               array(
                   'hasicon' => $hasnav5icon,
                   'linkicon' => $hasnav5icon,
                   'link' => $nav5buttonurl,
                   'linktext' => $nav5buttontext,
                   'linktarget' => $nav5target
               ) ,
               array(
                   'hasicon' => $hasnav6icon,
                   'linkicon' => $hasnav6icon,
                   'link' => $nav6buttonurl,
                   'linktext' => $nav6buttontext,
                   'linktarget' => $nav6target
               ) ,
               array(
                   'hasicon' => $hasnav7icon,
                   'linkicon' => $hasnav7icon,
                   'link' => $nav7buttonurl,
                   'linktext' => $nav7buttontext,
                   'linktarget' => $nav7target
               ) ,
               array(
                   'hasicon' => $hasnav8icon,
                   'linkicon' => $hasnav8icon,
                   'link' => $nav8buttonurl,
                   'linktext' => $nav8buttontext,
                   'linktarget' => $nav8target
               ) ,
           ) , 'fpcreateicon' => array(
               array(
                   'hasicon' => $hascreateicon,
                   'linkicon' => $hascreateicon,
                   'link' => $createbuttonurl,
                   'linktext' => $createbuttontext
               ) ,
           ) , 'fpslideicon' => array(
               array(
                   'hasicon' => $hasslideicon,
                   'linkicon' => $hasslideicon,
                   'link' => $slideiconbuttonurl,
                   'linktext' => $slideiconbuttontext
               ) ,
           ) , ];
           return $this->render_from_template('theme_competency/fpwonderbox', $fp_wonderboxcontext);
       }


       public function fp_slideshow() {
           global $PAGE;
           $theme = theme_config::load('competency');
           $slideshowon = $PAGE->theme->settings->showslideshow == 1;
           $hasslide1 = (empty($theme->setting_file_url('slide1image', 'slide1image'))) ? false : $theme->setting_file_url('slide1image', 'slide1image');
           $slide1 = (empty($PAGE->theme->settings->slide1title)) ? false : $PAGE->theme->settings->slide1title;
           $slide1content = (empty($PAGE->theme->settings->slide1content)) ? false : format_text($PAGE->theme->settings->slide1content);
           $showtext1 = (empty($PAGE->theme->settings->slide1title)) ? false : format_text($PAGE->theme->settings->slide1title);
           $hasslide2 = (empty($theme->setting_file_url('slide2image', 'slide2image'))) ? false : $theme->setting_file_url('slide2image', 'slide2image');
           $slide2 = (empty($PAGE->theme->settings->slide2title)) ? false : $PAGE->theme->settings->slide2title;
           $slide2content = (empty($PAGE->theme->settings->slide2content)) ? false : format_text($PAGE->theme->settings->slide2content);
           $showtext2 = (empty($PAGE->theme->settings->slide2title)) ? false : format_text($PAGE->theme->settings->slide2title);
           $hasslide3 = (empty($theme->setting_file_url('slide3image', 'slide3image'))) ? false : $theme->setting_file_url('slide3image', 'slide3image');
           $slide3 = (empty($PAGE->theme->settings->slide3title)) ? false : $PAGE->theme->settings->slide3title;
           $slide3content = (empty($PAGE->theme->settings->slide3content)) ? false : format_text($PAGE->theme->settings->slide3content);
           $showtext3 = (empty($PAGE->theme->settings->slide3title)) ? false : format_text($PAGE->theme->settings->slide3title);
           $fp_slideshow = ['hasfpslideshow' => $slideshowon, 'hasslide1' => $hasslide1 ? true : false, 'hasslide2' => $hasslide2 ? true : false, 'hasslide3' => $hasslide3 ? true : false, 'showtext1' => $showtext1 ? true : false, 'showtext2' => $showtext2 ? true : false, 'showtext3' => $showtext3 ? true : false, 'slide1' => array(
               'slidetitle' => $slide1,
               'slidecontent' => $slide1content
           ) , 'slide2' => array(
               'slidetitle' => $slide2,
               'slidecontent' => $slide2content
           ) , 'slide3' => array(
               'slidetitle' => $slide3,
               'slidecontent' => $slide3content
           ) , ];
           return $this->render_from_template('theme_competency/slideshow', $fp_slideshow);
       }

    public function fp_marketingtiles() {

        $hasmarketing1 = (empty($this->page->theme->settings->marketing1)) ? false : format_string($this->page->theme->settings->marketing1);
        $marketing1content = (empty($this->page->theme->settings->marketing1content)) ? false : format_text($this->page->theme->settings->marketing1content);
        $marketing1buttontext = (empty($this->page->theme->settings->marketing1buttontext)) ? false : format_string($this->page->theme->settings->marketing1buttontext);
        $marketing1buttonurl = (empty($this->page->theme->settings->marketing1buttonurl)) ? false : $this->page->theme->settings->marketing1buttonurl;
        $marketing1target = (empty($this->page->theme->settings->marketing1target)) ? false : $this->page->theme->settings->marketing1target;
        $marketing1image = (empty($this->page->theme->settings->marketing1image)) ? false : $this->page->theme->setting_file_url('marketing1image', 'marketing1image', true);
        $marketing1icon = (empty($this->page->theme->settings->marketing1icon)) ? false : format_string($this->page->theme->settings->marketing1icon);

        $hasmarketing2 = (empty($this->page->theme->settings->marketing2)) ? false : format_string($this->page->theme->settings->marketing2);
        $marketing2content = (empty($this->page->theme->settings->marketing2content)) ? false : format_text($this->page->theme->settings->marketing2content);
        $marketing2buttontext = (empty($this->page->theme->settings->marketing2buttontext)) ? false : format_string($this->page->theme->settings->marketing2buttontext);
        $marketing2buttonurl = (empty($this->page->theme->settings->marketing2buttonurl)) ? false : $this->page->theme->settings->marketing2buttonurl;
        $marketing2target = (empty($this->page->theme->settings->marketing2target)) ? false : $this->page->theme->settings->marketing2target;
        $marketing2image = (empty($this->page->theme->settings->marketing2image)) ? false : $this->page->theme->setting_file_url('marketing2image', 'marketing2image', true);
        $marketing2icon = (empty($this->page->theme->settings->marketing2icon)) ? false : format_string($this->page->theme->settings->marketing2icon);

        $hasmarketing3 = (empty($this->page->theme->settings->marketing3)) ? false : format_string($this->page->theme->settings->marketing3);
        $marketing3content = (empty($this->page->theme->settings->marketing3content)) ? false : format_text($this->page->theme->settings->marketing3content);
        $marketing3buttontext = (empty($this->page->theme->settings->marketing3buttontext)) ? false : format_string($this->page->theme->settings->marketing3buttontext);
        $marketing3buttonurl = (empty($this->page->theme->settings->marketing3buttonurl)) ? false : $this->page->theme->settings->marketing3buttonurl;
        $marketing3target = (empty($this->page->theme->settings->marketing3target)) ? false : $this->page->theme->settings->marketing3target;
        $marketing3image = (empty($this->page->theme->settings->marketing3image)) ? false : $this->page->theme->setting_file_url('marketing3image', 'marketing3image', true);
        $marketing3icon = (empty($this->page->theme->settings->marketing3icon)) ? false : format_string($this->page->theme->settings->marketing3icon);

        $hasmarketing4 = (empty($this->page->theme->settings->marketing4)) ? false : format_string($this->page->theme->settings->marketing4);
        $marketing4content = (empty($this->page->theme->settings->marketing4content)) ? false : format_text($this->page->theme->settings->marketing4content);
        $marketing4buttontext = (empty($this->page->theme->settings->marketing4buttontext)) ? false : format_string($this->page->theme->settings->marketing4buttontext);
        $marketing4buttonurl = (empty($this->page->theme->settings->marketing4buttonurl)) ? false : $this->page->theme->settings->marketing4buttonurl;
        $marketing4target = (empty($this->page->theme->settings->marketing4target)) ? false : $this->page->theme->settings->marketing4target;
        $marketing4image = (empty($this->page->theme->settings->marketing4image)) ? false : $this->page->theme->setting_file_url('marketing4image', 'marketing4image', true);
        $marketing4icon = (empty($this->page->theme->settings->marketing4icon)) ? false : format_string($this->page->theme->settings->marketing4icon);

        $hasmarketing5 = (empty($this->page->theme->settings->marketing5)) ? false : format_string($this->page->theme->settings->marketing5);
        $marketing5content = (empty($this->page->theme->settings->marketing5content)) ? false : format_text($this->page->theme->settings->marketing5content);
        $marketing5buttontext = (empty($this->page->theme->settings->marketing5buttontext)) ? false : format_string($this->page->theme->settings->marketing5buttontext);
        $marketing5buttonurl = (empty($this->page->theme->settings->marketing5buttonurl)) ? false : $this->page->theme->settings->marketing5buttonurl;
        $marketing5target = (empty($this->page->theme->settings->marketing5target)) ? false : $this->page->theme->settings->marketing5target;
        $marketing5image = (empty($this->page->theme->settings->marketing5image)) ? false : $this->page->theme->setting_file_url('marketing5image', 'marketing5image', true);
        $marketing5icon = (empty($this->page->theme->settings->marketing5icon)) ? false : format_string($this->page->theme->settings->marketing5icon);

        $hasmarketing6 = (empty($this->page->theme->settings->marketing6)) ? false : format_string($this->page->theme->settings->marketing6);
        $marketing6content = (empty($this->page->theme->settings->marketing6content)) ? false : format_text($this->page->theme->settings->marketing6content);
        $marketing6buttontext = (empty($this->page->theme->settings->marketing6buttontext)) ? false : format_string($this->page->theme->settings->marketing6buttontext);
        $marketing6buttonurl = (empty($this->page->theme->settings->marketing6buttonurl)) ? false : $this->page->theme->settings->marketing6buttonurl;
        $marketing6target = (empty($this->page->theme->settings->marketing6target)) ? false : $this->page->theme->settings->marketing6target;
        $marketing6image = (empty($this->page->theme->settings->marketing6image)) ? false : $this->page->theme->setting_file_url('marketing6image', 'marketing6image', true);
        $marketing6icon = (empty($this->page->theme->settings->marketing6icon)) ? false : format_string($this->page->theme->settings->marketing6icon);

        $hasmarketing7 = (empty($this->page->theme->settings->marketing7)) ? false : format_string($this->page->theme->settings->marketing7);
        $marketing7content = (empty($this->page->theme->settings->marketing7content)) ? false : format_text($this->page->theme->settings->marketing7content);
        $marketing7buttontext = (empty($this->page->theme->settings->marketing7buttontext)) ? false : format_string($this->page->theme->settings->marketing7buttontext);
        $marketing7buttonurl = (empty($this->page->theme->settings->marketing7buttonurl)) ? false : $this->page->theme->settings->marketing7buttonurl;
        $marketing7target = (empty($this->page->theme->settings->marketing7target)) ? false : $this->page->theme->settings->marketing7target;
        $marketing7image = (empty($this->page->theme->settings->marketing7image)) ? false : $this->page->theme->setting_file_url('marketing7image', 'marketing7image', true);
        $marketing7icon = (empty($this->page->theme->settings->marketing7icon)) ? false : format_string($this->page->theme->settings->marketing7icon);

        $hasmarketing8 = (empty($this->page->theme->settings->marketing8)) ? false : format_string($this->page->theme->settings->marketing8);
        $marketing8content = (empty($this->page->theme->settings->marketing8content)) ? false : format_text($this->page->theme->settings->marketing8content);
        $marketing8buttontext = (empty($this->page->theme->settings->marketing8buttontext)) ? false : format_string($this->page->theme->settings->marketing8buttontext);
        $marketing8buttonurl = (empty($this->page->theme->settings->marketing8buttonurl)) ? false : $this->page->theme->settings->marketing8buttonurl;
        $marketing8target = (empty($this->page->theme->settings->marketing8target)) ? false : $this->page->theme->settings->marketing8target;
        $marketing8image = (empty($this->page->theme->settings->marketing8image)) ? false : $this->page->theme->setting_file_url('marketing8image', 'marketing8image', true);
        $marketing8icon = (empty($this->page->theme->settings->marketing8icon)) ? false : format_string($this->page->theme->settings->marketing8icon);

        $hasmarketing9 = (empty($this->page->theme->settings->marketing9)) ? false : format_string($this->page->theme->settings->marketing9);
        $marketing9content = (empty($this->page->theme->settings->marketing9content)) ? false : format_text($this->page->theme->settings->marketing9content);
        $marketing9buttontext = (empty($this->page->theme->settings->marketing9buttontext)) ? false : format_string($this->page->theme->settings->marketing9buttontext);
        $marketing9buttonurl = (empty($this->page->theme->settings->marketing9buttonurl)) ? false : $this->page->theme->settings->marketing9buttonurl;
        $marketing9target = (empty($this->page->theme->settings->marketing9target)) ? false : $this->page->theme->settings->marketing9target;
        $marketing9image = (empty($this->page->theme->settings->marketing9image)) ? false : $this->page->theme->setting_file_url('marketing9image', 'marketing9image', true);
        $marketing9icon = (empty($this->page->theme->settings->marketing9icon)) ? false : format_string($this->page->theme->settings->marketing9icon);

        $fp_marketingtiles = ['hasmarkettiles' => ($hasmarketing1 || $hasmarketing2 || $hasmarketing3) ? true : false, 'markettiles' => array(
            array(
                'hastile' => $hasmarketing1,
                'tileimage' => $marketing1image,
                'content' => $marketing1content,
                'title' => $hasmarketing1,
                'hasbutton' => $marketing1buttonurl,
                'button' => "<a href = '$marketing1buttonurl' title = '$marketing1buttontext' alt='$marketing1buttontext' class='btn btn-primary' target='$marketing1target'> $marketing1buttontext </a>",
                'marketingicon' => $marketing1icon,
            ) ,
            array(
                'hastile' => $hasmarketing2,
                'tileimage' => $marketing2image,
                'content' => $marketing2content,
                'title' => $hasmarketing2,
                'hasbutton' => $marketing2buttonurl,
                'button' => "<a href = '$marketing2buttonurl' title = '$marketing2buttontext' alt='$marketing2buttontext' class='btn btn-primary' target='$marketing2target'> $marketing2buttontext </a>",
                'marketingicon' => $marketing2icon,
            ) ,
            array(
                'hastile' => $hasmarketing3,
                'tileimage' => $marketing3image,
                'content' => $marketing3content,
                'title' => $hasmarketing3,
                'hasbutton' => $marketing3buttonurl,
                'button' => "<a href = '$marketing3buttonurl' title = '$marketing3buttontext' alt='$marketing3buttontext' class='btn btn-primary' target='$marketing3target'> $marketing3buttontext </a>",
                'marketingicon' => $marketing3icon,
            ) ,
            array(
                'hastile' => $hasmarketing4,
                'tileimage' => $marketing4image,
                'content' => $marketing4content,
                'title' => $hasmarketing4,
                'hasbutton' => $marketing4buttonurl,
                'button' => "<a href = '$marketing4buttonurl' title = '$marketing4buttontext' alt='$marketing4buttontext' class='btn btn-primary' target='$marketing4target'> $marketing4buttontext </a>",
                'marketingicon' => $marketing4icon,
            ) ,
            array(
                'hastile' => $hasmarketing5,
                'tileimage' => $marketing5image,
                'content' => $marketing5content,
                'title' => $hasmarketing5,
                'hasbutton' => $marketing5buttonurl,
                'button' => "<a href = '$marketing5buttonurl' title = '$marketing5buttontext' alt='$marketing5buttontext' class='btn btn-primary' target='$marketing5target'> $marketing5buttontext </a>",
                'marketingicon' => $marketing5icon,
            ) ,
            array(
                'hastile' => $hasmarketing6,
                'tileimage' => $marketing6image,
                'content' => $marketing6content,
                'title' => $hasmarketing6,
                'hasbutton' => $marketing6buttonurl,
                'button' => "<a href = '$marketing6buttonurl' title = '$marketing6buttontext' alt='$marketing6buttontext' class='btn btn-primary' target='$marketing6target'> $marketing6buttontext </a>",
                'marketingicon' => $marketing6icon,
            ) ,
            array(
                'hastile' => $hasmarketing7,
                'tileimage' => $marketing7image,
                'content' => $marketing7content,
                'title' => $hasmarketing7,
                'hasbutton' => $marketing7buttonurl,
                'button' => "<a href = '$marketing7buttonurl' title = '$marketing7buttontext' alt='$marketing7buttontext' class='btn btn-primary' target='$marketing7target'> $marketing7buttontext </a>",
                'marketingicon' => $marketing7icon,
            ) ,
            array(
                'hastile' => $hasmarketing8,
                'tileimage' => $marketing8image,
                'content' => $marketing8content,
                'title' => $hasmarketing8,
                'hasbutton' => $marketing8buttonurl,
                'button' => "<a href = '$marketing8buttonurl' title = '$marketing8buttontext' alt='$marketing8buttontext' class='btn btn-primary' target='$marketing8target'> $marketing8buttontext </a>",
                'marketingicon' => $marketing8icon,
            ) ,
            array(
                'hastile' => $hasmarketing9,
                'tileimage' => $marketing9image,
                'content' => $marketing9content,
                'title' => $hasmarketing9,
                'hasbutton' => $marketing9buttonurl,
                'button' => "<a href = '$marketing9buttonurl' title = '$marketing9buttontext' alt='$marketing9buttontext' class='btn btn-primary' target='$marketing9target'> $marketing9buttontext </a>",
                'marketingicon' => $marketing9icon,
            ) ,
        ) ,
    ];
        return $this->render_from_template('theme_competency/fpmarkettiles', $fp_marketingtiles);
    }

    public function favicon() {
        $favicon = $this->page->theme->setting_file_url('favicon', 'favicon');

        if (empty($favicon)) {
            return $this->page->theme->image_url('favicon', 'theme');
        } else {
            return $favicon;
        }
    }

    public function social_icons() {
        global $PAGE;
        $hasfacebook = (empty($PAGE->theme->settings->facebook)) ? false : $PAGE->theme->settings->facebook;
        $hastwitter = (empty($PAGE->theme->settings->twitter)) ? false : $PAGE->theme->settings->twitter;
        $hasgoogleplus = (empty($PAGE->theme->settings->googleplus)) ? false : $PAGE->theme->settings->googleplus;
        $haslinkedin = (empty($PAGE->theme->settings->linkedin)) ? false : $PAGE->theme->settings->linkedin;
        $hasyoutube = (empty($PAGE->theme->settings->youtube)) ? false : $PAGE->theme->settings->youtube;
        $hasflickr = (empty($PAGE->theme->settings->flickr)) ? false : $PAGE->theme->settings->flickr;
        $hasvk = (empty($PAGE->theme->settings->vk)) ? false : $PAGE->theme->settings->vk;
        $haspinterest = (empty($PAGE->theme->settings->pinterest)) ? false : $PAGE->theme->settings->pinterest;
        $hasinstagram = (empty($PAGE->theme->settings->instagram)) ? false : $PAGE->theme->settings->instagram;
        $hasskype = (empty($PAGE->theme->settings->skype)) ? false : $PAGE->theme->settings->skype;
        $haswebsite = (empty($PAGE->theme->settings->website)) ? false : $PAGE->theme->settings->website;
        $hasblog = (empty($PAGE->theme->settings->blog)) ? false : $PAGE->theme->settings->blog;
        $hasvimeo = (empty($PAGE->theme->settings->vimeo)) ? false : $PAGE->theme->settings->vimeo;
        $hastumblr = (empty($PAGE->theme->settings->tumblr)) ? false : $PAGE->theme->settings->tumblr;
        $hassocial1 = (empty($PAGE->theme->settings->social1)) ? false : $PAGE->theme->settings->social1;
        $social1icon = (empty($PAGE->theme->settings->socialicon1)) ? 'globe' : $PAGE->theme->settings->socialicon1;
        $hassocial2 = (empty($PAGE->theme->settings->social2)) ? false : $PAGE->theme->settings->social2;
        $social2icon = (empty($PAGE->theme->settings->socialicon2)) ? 'globe' : $PAGE->theme->settings->socialicon2;
        $hassocial3 = (empty($PAGE->theme->settings->social3)) ? false : $PAGE->theme->settings->social3;
        $social3icon = (empty($PAGE->theme->settings->socialicon3)) ? 'globe' : $PAGE->theme->settings->socialicon3;
        $socialcontext = [
        // If any of the above social networks are true, sets this to true.
        'hassocialnetworks' => ($hasfacebook || $hastwitter || $hasgoogleplus || $hasflickr || $hasinstagram || $hasvk || $haslinkedin || $haspinterest || $hasskype || $haslinkedin || $haswebsite || $hasyoutube || $hasblog || $hasvimeo || $hastumblr || $hassocial1 || $hassocial2 || $hassocial3) ? true : false, 'socialicons' => array(
            array(
                'haslink' => $hasfacebook,
                'linkicon' => 'facebook'
            ) ,
            array(
                'haslink' => $hastwitter,
                'linkicon' => 'twitter'
            ) ,
            array(
                'haslink' => $hasgoogleplus,
                'linkicon' => 'google-plus'
            ) ,
            array(
                'haslink' => $haslinkedin,
                'linkicon' => 'linkedin'
            ) ,
            array(
                'haslink' => $hasyoutube,
                'linkicon' => 'youtube'
            ) ,
            array(
                'haslink' => $hasflickr,
                'linkicon' => 'flickr'
            ) ,
            array(
                'haslink' => $hasvk,
                'linkicon' => 'vk'
            ) ,
            array(
                'haslink' => $haspinterest,
                'linkicon' => 'pinterest'
            ) ,
            array(
                'haslink' => $hasinstagram,
                'linkicon' => 'instagram'
            ) ,
            array(
                'haslink' => $hasskype,
                'linkicon' => 'skype'
            ) ,
            array(
                'haslink' => $haswebsite,
                'linkicon' => 'globe'
            ) ,
            array(
                'haslink' => $hasblog,
                'linkicon' => 'bookmark'
            ) ,
            array(
                'haslink' => $hasvimeo,
                'linkicon' => 'vimeo-square'
            ) ,
            array(
                'haslink' => $hastumblr,
                'linkicon' => 'tumblr'
            ) ,
            array(
                'haslink' => $hassocial1,
                'linkicon' => $social1icon
            ) ,
            array(
                'haslink' => $hassocial2,
                'linkicon' => $social2icon
            ) ,
            array(
                'haslink' => $hassocial3,
                'linkicon' => $social3icon
            ) ,
        ) ];
        return $this->render_from_template('theme_competency/socialicons', $socialcontext);
    }

    public function get_generated_image_for_id($id) {
        // See if user uploaded a custom header background to the theme.
        $headerbg = $this->page->theme->setting_file_url('headerdefaultimage', 'headerdefaultimage');
        if (isset($headerbg)) {
            return $headerbg;
        } else {
            // Use the default theme image when no course image is detected.
            return $this->image_url('noimg', 'theme')->out();
        }
    }

    // The following code is a copied work of the code from theme Essential https://moodle.org/plugins/theme_essential, @copyright Gareth J Barnard
    protected static function timeaccesscompare($a, $b) {
        // Timeaccess is lastaccess entry and timestart an enrol entry.
        if ((!empty($a->timeaccess)) && (!empty($b->timeaccess))) {
            // Both last access.
            if ($a->timeaccess == $b->timeaccess) {
                return 0;
            }
            return ($a->timeaccess > $b->timeaccess) ? -1 : 1;
        }
        else if ((!empty($a->timestart)) && (!empty($b->timestart))) {
            // Both enrol.
            if ($a->timestart == $b->timestart) {
                return 0;
            }
            return ($a->timestart > $b->timestart) ? -1 : 1;
        }
        // Must be comparing an enrol with a last access.
        // -1 is to say that 'a' comes before 'b'.
        if (!empty($a->timestart)) {
            // 'a' is the enrol entry.
            return -1;
        }
        // 'b' must be the enrol entry.
        return 1;
    }
    // End copied code

    // The following code is a derivative work of the code from theme Essential https://moodle.org/plugins/theme_essential, by Gareth J Barnard
    public function competency_mycourses() {
        $context = $this->page->context;
        $menu = new custom_menu();

            $branchtitle = get_string('latestcourses', 'theme_competency');
            $branchlabel = $branchtitle;
            $branchurl = new moodle_url('/my/courses.php');
            $branchsort = 10000;
            $branch = $menu->add($branchlabel, $branchurl, $branchtitle, $branchsort);
            $dashlabel = get_string('viewallcourses', 'theme_competency');
            $dashurl = new moodle_url("/my/courses.php");
            $dashtitle = $dashlabel;
            $nomycourses = get_string('nomycourses', 'theme_competency');
            $courses = enrol_get_my_courses(null, 'sortorder ASC');

                if ($courses) {
                    // We have something to work with.  Get the last accessed information for the user and populate.
                    global $DB, $USER;
                    $lastaccess = $DB->get_records('user_lastaccess', array('userid' => $USER->id) , '', 'courseid, timeaccess');
                    if ($lastaccess) {
                        foreach ($courses as $course) {
                            if (!empty($lastaccess[$course->id])) {
                                $course->timeaccess = $lastaccess[$course->id]->timeaccess;
                            }
                        }
                    }
                    // Determine if we need to query the enrolment and user enrolment tables.
                    $enrolquery = false;
                    foreach ($courses as $course) {
                        if (empty($course->timeaccess)) {
                            $enrolquery = true;
                            break;
                        }
                    }
                    if ($enrolquery) {
                        // We do.
                        $params = array(
                            'userid' => $USER->id
                        );
                        $sql = "SELECT ue.id, e.courseid, ue.timestart
                            FROM {enrol} e
                            JOIN {user_enrolments} ue ON (ue.enrolid = e.id AND ue.userid = :userid)";
                        $enrolments = $DB->get_records_sql($sql, $params, 0, 0);
                        if ($enrolments) {
                            // Sort out any multiple enrolments on the same course.
                            $userenrolments = array();
                            foreach ($enrolments as $enrolment) {
                                if (!empty($userenrolments[$enrolment->courseid])) {
                                    if ($userenrolments[$enrolment->courseid] < $enrolment->timestart) {
                                        // Replace.
                                        $userenrolments[$enrolment->courseid] = $enrolment->timestart;
                                    }
                                }
                                else {
                                    $userenrolments[$enrolment->courseid] = $enrolment->timestart;
                                }
                            }
                            // We don't need to worry about timeend etc. as our course list will be valid for the user from above.
                            foreach ($courses as $course) {
                                if (empty($course->timeaccess)) {
                                    $course->timestart = $userenrolments[$course->id];
                                }
                            }
                        }
                    }
                    uasort($courses, array($this,'timeaccesscompare'));
                }
                else {
                    return $nomycourses;
                }
                $sortorder = $lastaccess;
                $i = 0;
                foreach ($courses as $course) {
                    if ($course->visible && $i < 7) {
                        $branch->add(format_string($course->fullname) , new moodle_url('/course/view.php?id=' . $course->id) , format_string($course->shortname));
                    }
                    $i += 1;
                }
                $branch->add($dashlabel, $dashurl, $dashtitle);
                $content = '';

                foreach ($menu->get_children() as $item) {
                    $context = $item->export_for_template($this);
                    $content .= $this->render_from_template('theme_competency/mycourses', $context);
                }
        return $content;
    }
    // End derivative work


    /*
    * Dashboard matrix
    * competency Training Customized google analytics
    */
    public function dashboard_matrix()
    {
      global $USER, $DB;
      $user_id = $USER->id;

                    $maximum = $DB->get_records_sql("SELECT c.id AS cid,
                                          c.shortname AS shortname, c.fullname AS fullname,
                                          ct.name AS category, u.firstname AS firstname,
                                          u.lastname AS lastname, u.id AS u_id,
                                          g.rawgrademax AS rawgrademax,
                                          g.rawgrademin AS rawgrademin,
                                          g.rawgrade AS rawgrade,
                                          g.finalgrade AS finalgrade
                                          FROM {user} AS u
                                          JOIN {grade_grades} AS g
                                          JOIN {course} AS c
                                          JOIN {course_categories} AS ct
                                          JOIN {grade_items} AS gt
                                          WHERE g.userid = u.id AND g.itemid =  gt.id AND u.id = '$user_id'
                                          AND ct.id = c.category AND c.id = gt.courseid ORDER BY c.id ASC
                                          LIMIT 1
                                          ");
                                foreach ($maximum as $show_result) {
                                    $userid = $show_result->u_id;
                                    $course_id = $show_result->cid;
                                    $user_name = $show_result->firstname.' '.$show_result->lastname;
                                    $coursename = $show_result->fullname;
                                    $courseshortname = $show_result->shortname;
                                    $coursecategory = $show_result->category;
                                    $maximum_score = $show_result->rawgrademax;
                                    $minimum_score = $show_result->rawgrademin;
                                    $final_grade = $show_result->finalgrade;
                                    $miiihn = $minimum_score + 1;
                                    if($final_grade=='100.00000'){
                                        $final_grade = '0';
                                    }else{
                                        $final_grade = $final_grade;
                                    }

                                    $minimum = $DB->get_record_sql("SELECT c.id AS cid,
                                                          c.shortname AS shortname, c.fullname AS fullname,
                                                          ct.name AS category, u.firstname AS firstname,
                                                          u.lastname AS lastname, u.id AS u_id,
                                                          g.rawgrademax AS rawgrademax,
                                                          g.rawgrademin AS rawgrademin,
                                                          g.rawgrade AS rawgrade,
                                                          g.finalgrade AS finalgrade
                                                          FROM {user} AS u
                                                          JOIN {grade_grades} AS g
                                                          JOIN {course} AS c
                                                          JOIN {course_categories} AS ct
                                                          JOIN {grade_items} AS gt
                                                          WHERE g.userid = u.id AND g.itemid =  gt.id AND u.id = '$user_id'
                                                          AND ct.id = c.category AND c.id = gt.courseid ORDER BY c.id DESC
                                                          LIMIT 1
                                                          ");

                                                    $userid2 = $minimum->u_id;
                                                    $course_id2 = $minimum->cid;
                                                    $user_name2 = $minimum->firstname.' '.$show_result->lastname;
                                                    $coursename2 = $minimum->fullname;
                                                    $courseshortname2 = $minimum->shortname;
                                                    $coursecategory2 = $minimum->category;
                                                    $maximum_score2 = $minimum->rawgrademax;
                                                    $minimum_score2 = $minimum->rawgrademin;
                                                    $final = $minimum->finalgrade;
                                                    $miiin = $minimum_score2 + 1;

                                            $competency = $DB->get_records_sql("SELECT
                                                  f.shortname AS framework,
                                                  comp.shortname AS competency_path,
                                                  cp.fullname AS course,
                                                  mcomp.ruleoutcome AS total,
                                                  COUNT(cccomp.competencyid) AS 'nb course'
                                                  FROM {competency} AS comp
                                                  INNER JOIN {competency_framework} AS f ON comp.competencyframeworkid = f.id
                                                  INNER JOIN {competency_modulecomp} AS mcomp ON mcomp.competencyid = comp.id
                                                  LEFT JOIN {competency_coursecomp} AS cccomp ON cccomp.competencyid = comp.id
                                                  INNER JOIN {course} AS cp ON cccomp.courseid = cp.id WHERE cccomp.courseid = $course_id2
                                                  GROUP BY comp.id, comp.shortname");
                                                foreach ($competency as $showcompetency) {
                                                  //get record
                                                  $res1 = $DB->get_record_sql("SELECT shortname FROM mdl_competency  WHERE id='2'");
                                                  $res2 = $DB->get_record_sql("SELECT shortname FROM mdl_competency WHERE id='1'");
                                                  $compaa = $res1->shortname;
                                                  $comp33 = $res2->shortname;
                                                  $comp2 = str_replace("communication,","",$compaa);
                                                  $comp3 = str_replace("Demonstrate"," Show",$comp33);
                                                  $totalss= (count($showcompetency));
                                                  $Competency= $showcompetency->framework;
                                                  $total = $showcompetency->total;
                                                  $rows = array($showcompetency->competency_path);
                                                  $comp11 = $rows[0];
                                                  $comp1 = str_replace("Demonstrate"," Show",$comp11);
                                                  //$comp2 = $rows[1];
                                                  //$comp3 = $rows[2];
                                                  $com_course = $showcompetency->course;
                                                  if($total=='3'){
                                                    $t_1 = '33.3';
                                                    $t_2 = '33.3';
                                                    $t_3 = '33.3';
                                                  }else if($total=='2'){
                                                    $t_1 = '33.3';
                                                    $t_2 = '33.3';
                                                    $t_3 = '0.00';
                                                  }else if($total=='1'){
                                                    $t_1 = '33.3';
                                                    $t_2 = '0.00';
                                                    $t_3 = '0.00';
                                                  }else{
                          													$a = $total;
                          													$b = 3;
                          													$per = ($b/$a) * 100;
                          													$tot = $per / 3;
                          													$t_1 = $tot;
                          													$t_2 = $tot;
                          													$t_3 = $tot;
                        												  }


                                                  $ttt = round($t_1 + $t_2 + $t_3);
                                                  $tt = round($t_1 + $t_2);
                                                  $t = round($t_1);


                                    $templatecontext = [
                                        'userid' => $userid,
                                        'user_name' => $user_name,
                                        'coursename' => $coursename,
                                        'courseshortname' => $courseshortname,
                                        'maximum_score' => $maximum_score,
                                        'minimum_score' => $miiihn,
                                        'final_grade' => $final_grade,

                                        'userid2' => $userid2,
                                        'user_name2' => $user_name2,
                                        'coursename2' => $coursename2,
                                        'courseshortname2' => $courseshortname2,
                                        'maximum' => $maximum_score2,
                                        'minimum' => $miiin,
                                        'final' => $final,

                                        'competence1' => $t_1,
                                        'competence2' => $t_2,
                                        'competence3' => $t_3,
                                        'total' => $total,
                                        'competency'=> $Competency,
                                        'compet'=> $tt,
                                        'compet2'=> $ttt,
                                        'compet3'=> $t,
                                        'comp1'=> $comp1,
                                        'comp2'=> $comp2,
                                        'comp3'=> $comp3,
                                        'courses_com' => $com_course,

                                    ];
                                    return $this->render_from_template('theme_competency/dashboard', $templatecontext);
                                }
                            }

  }


  public function footnote() {
      global $PAGE;
      $footnote = '';
      $footnote = (empty($PAGE->theme->settings->footnote)) ? false : format_text($PAGE->theme->settings->footnote);
      return $footnote;
  }
  public function brandorganization_footer() {
      $theme = theme_config::load('competency');
      $setting = format_string($theme->settings->brandorganization);
      return $setting != '' ? $setting : '';
  }
  public function brandwebsite_footer() {
      $theme = theme_config::load('competency');
      $setting = $theme->settings->brandwebsite;
      return $setting != '' ? $setting : '';
  }
  public function brandphone_footer() {
      $theme = theme_config::load('competency');
      $setting = $theme->settings->brandphone;
      return $setting != '' ? $setting : '';
  }
  public function brandemail_footer() {
      $theme = theme_config::load('competency');
      $setting = $theme->settings->brandemail;
      return $setting != '' ? $setting : '';
  }

  public function logintext_custom() {
      global $PAGE;
      $logintext_custom = '';
      $logintext_custom = (empty($PAGE->theme->settings->fptextboxlogout)) ? false : format_text($PAGE->theme->settings->fptextboxlogout);
      return $logintext_custom;
  }

  public function render_login(\core_auth\output\login $form) {
      global $SITE, $PAGE;
      $context = $form->export_for_template($this);
      // Override because rendering is not supported in template yet.
      $context->cookieshelpiconformatted = $this->help_icon('cookiesenabled');
      $context->errorformatted = $this->error_text($context->error);
      $url = $this->get_logo_url();
      // Custom logins.
      $context->logintext_custom = format_text($PAGE->theme->settings->fptextboxlogout);
      $context->logintopimage = $PAGE->theme->setting_file_url('logintopimage', 'logintopimage');
      $context->hascustomlogin = $PAGE->theme->settings->showcustomlogin == 1;
      $context->hasdefaultlogin = $PAGE->theme->settings->showcustomlogin == 0;
      $context->alertbox = format_text($PAGE->theme->settings->alertbox, FORMAT_HTML, array(
          'noclean' => true
      ));
      if ($url) {
          $url = $url->out(false);
      }
      $context->logourl = $url;
      $context->sitename = format_string($SITE->fullname, true, ['context' => context_course::instance(SITEID) , "escape" => false]);
      return $this->render_from_template('core/loginform', $context);
  }

}
