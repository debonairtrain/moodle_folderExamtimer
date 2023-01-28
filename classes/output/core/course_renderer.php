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
 * course_renderer.php
 *
 * This is built using the boost template to allow for new theme's using
 * Moodle's new Boost theme engine
 *
 * @package     theme_competency
 * @copyright   2022 Debonair Training Ltd, debonairtraining.com
 * @author      competency Dev Team
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */



namespace theme_competency\output\core;

use moodle_url;
use lang_string;
use html_writer;
use core_course_category;
use coursecat_helper;
use stdClass;
use context_course;
use core_course_list_element;

/**
 * This class has function for core course renderer
 * @package     theme_competency
 * @copyright   2022 competency Training Ltd, competencytraining.com
 * @author      competency Dev Team
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class course_renderer extends \core_course_renderer {

    /**
     * Renderer function for the frontpage available courses.
     * @return string
     */
    public function frontpage_available_courses() {
        /* available courses */
        global $CFG;
        $output = '';
        $chelper = new coursecat_helper();
        $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED)->set_courses_display_options(array(
            'recursive' => true,
            'limit' => $CFG->frontpagecourselimit,
            'viewmoreurl' => new moodle_url('/course/index.php'),
            'viewmoretext' => new lang_string('fulllistofcourses')
        ));

        $chelper->set_attributes(array('class' => 'frontpage-course-list-all'));
        $courses = core_course_category::get(0)->get_courses($chelper->get_courses_display_options());
        $totalcount = core_course_category::get(0)->get_courses_count($chelper->get_courses_display_options());

        $rcourseids = array_keys($courses);
        $newcourse = get_string('availablecourses');

        $header = '<div id="frontpage-course-list"><h2>'.$newcourse.'</h2><div class="courses frontpage-course-list-all">';
        $footer = '</div></div>';
        $content = '';
        if (count($rcourseids) > 0) {
            $content .= '<div class="row">';
            foreach ($rcourseids as $courseid) {

                $rowcontent = '';

                $course = get_course($courseid);

                $no = get_config('theme_competency', 'patternselect');
                $nimgp = (empty($no)||$no == "default") ? 'default/no-image' : 'cs0'.$no.'/no-image';
                $noimgurl = $this->output->image_url($nimgp, 'theme');
                $courseurl = new moodle_url('/course/view.php', array('id' => $courseid ));

                if ($course instanceof stdClass) {
                    $course = new core_course_list_element($course);
                }

                $imgurl = '';
                $context = context_course::instance($course->id);

                foreach ($course->get_course_overviewfiles() as $file) {
                    $isimage = $file->is_valid_image();
                    $imgurl = file_encode_url("$CFG->wwwroot/pluginfile.php",
                        '/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
                        $file->get_filearea(). $file->get_filepath(). $file->get_filename(), !$isimage);
                    if (!$isimage) {
                        $imgurl = $noimgurl;
                    }
                }

                if (empty($imgurl)) {
                    $imgurl = $noimgurl;
                }

                $rowcontent .= '<div class="col-md-3 col-sm-6"><div class="fp-coursebox"><div class="fp-coursethumb">
                <a href="'.$courseurl.'"><img src="'.$imgurl.'" width="243" height="165" alt=""></a></div>
                <div class="fp-courseinfo"><h5><a href="'.$courseurl.'">'.$course->get_formatted_name().'</a></h5>
                </div></div></div>';
                $content .= $rowcontent;
            }
            $content .= '</div>';
        }

        $coursehtml = $header.$content.$footer;
        $output .= $coursehtml;

      //  $output .= $this->output->render_from_template('theme_competency/search', (object)[]);
        if (!$totalcount && !$this->page->user_is_editing() && has_capability('moodle/course:create', context_system::instance())) {
            // Print link to create a new course, for the 1st available category.
            $output .= $this->add_new_course_button();
        }
        return $output;
    }



    /**
     * Displays one course in the list of courses.
     *
     * This is an internal function, to display an information about just one course
     * please use {@see core_course_renderer::course_info_box()}
     *
     * @param coursecat_helper $chelper various display options
     * @param course_in_list|stdClass $course
     * @param string $additionalclasses additional classes to add to the main <div> tag (usually
     *    depend on the course position in list - first/last/even/odd)
     * @return string
     */
    protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '') {
        global $CFG;
        if (!isset($this->strings->summary)) {
            $this->strings->summary = get_string('summary');
        }
        if ($chelper->get_show_courses() <= self::COURSECAT_SHOW_COURSES_COUNT) {
            return '';
        }
        if ($course instanceof stdClass) {
            $course = new core_course_list_element($course);
        }
        $content = '';
        $classes = trim('coursebox clearfix '. $additionalclasses);
        if ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED) {
            $nametag = 'h3';
        } else {
            $classes .= ' collapsed';
            $nametag = 'div';
        }

        // Coursebox.
        $content .= html_writer::start_tag('div', array(
            'class' => $classes,
            'data-courseid' => $course->id,
            'data-type' => self::COURSECAT_TYPE_COURSE,
        ));

        $content .= html_writer::start_tag('div', array('class' => 'info'));

        // Course name.
        $coursename = $chelper->get_course_formatted_name($course);
        $coursenamelink = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)),
                                            $coursename, array('class' => $course->visible ? '' : 'dimmed'));
        $content .= html_writer::tag($nametag, $coursenamelink, array('class' => 'coursename'));
        // If we display course in collapsed form but the course has summary or course contacts, display the link to the info page.
        $content .= html_writer::start_tag('div', array('class' => 'moreinfo'));
        if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED) {
            if ($course->has_summary() || $course->has_course_contacts() || $course->has_course_overviewfiles()) {
                $url = new moodle_url('/course/info.php', array('id' => $course->id));
                $image = $this->output->pix_icon('i/info', $this->strings->summary);
                $content .= html_writer::link($url, $image, array('title' => $this->strings->summary));
                // Make sure JS file to expand course content is included.
                $this->coursecat_include_js();
            }
        }
        $content .= html_writer::end_tag('div'); // Moreinfo.

        // Print enrolmenticons.
        if ($icons = enrol_get_course_info_icons($course)) {
            $content .= html_writer::start_tag('div', array('class' => 'enrolmenticons'));
            foreach ($icons as $pixicon) {
                $content .= $this->render($pixicon);
            }
            $content .= html_writer::end_tag('div'); // Enrolmenticons.
        }

        $content .= html_writer::end_tag('div'); // Enfo.

        if (empty($course->get_course_overviewfiles())) {
            $class = "content-block";
        } else {
            $class = "";
        }
        $content .= html_writer::start_tag('div', array('class' => 'content '.$class));
        $content .= $this->coursecat_coursebox_content($chelper, $course);
        // Content.
        $content .= html_writer::end_tag('div');
         // Coursebox.
        $content .= html_writer::end_tag('div');
        return $content;
    }

    /**
     * Outputs contents for frontpage as configured in $CFG->frontpage or $CFG->frontpageloggedin
     *
     * @return string
     */
    public function frontpage() {
        global $CFG, $SITE;
        //require_once($CFG->dirroot. "/theme/competency/layout/includes/marketingspots.php");
        $output = '';
        // $output .= $this->bannerimage_settings();
        $output .= $this->output->render_from_template('theme_competency/others', (object)[]);
        $output .= $this->output->render_from_template('theme_competency/search', (object)[]);
        // $output .= $this->output->render_from_template('theme_competency/dashboard', (object)[]);
        $output .= $this->dashboard_matrix();
        $output .= $this->fp_wonderbox();
        $output .= $this->fp_marketingtiles();


        if (isloggedin() and !isguestuser() and isset($CFG->frontpageloggedin)) {
            $frontpagelayout = $CFG->frontpageloggedin;
        } else {
            $frontpagelayout = $CFG->frontpage;
        }

        foreach (explode(',', $frontpagelayout) as $v) {
            switch ($v) {
                // Display the main part of the front page.
                case FRONTPAGENEWS:
                    if ($SITE->newsitems) {
                        // Print forums only when needed.
                        require_once($CFG->dirroot .'/mod/forum/lib.php');
                        if (($newsforum = forum_get_course_forum($SITE->id, 'news')) &&
                                ($forumcontents = $this->frontpage_news($newsforum))) {
                            $newsforumcm = get_fast_modinfo($SITE)->instances['forum'][$newsforum->id];
                            $output .= $this->frontpage_part('skipsitenews', 'site-news-forum',
                                $newsforumcm->get_formatted_name(), $forumcontents);
                        }
                    }
                    break;

                case FRONTPAGEENROLLEDCOURSELIST:
                    $mycourseshtml = $this->frontpage_my_courses();
                    if (!empty($mycourseshtml)) {
                        $output .= $this->frontpage_part('skipmycourses', 'frontpage-course-list',
                            get_string('mycourses'), $mycourseshtml);
                    }
                    break;

                case FRONTPAGEALLCOURSELIST:
                    $availablecourseshtml = $this->frontpage_available_courses();
                    $output .= $this->frontpage_part('skipavailablecourses', 'frontpage-available-course-list',
                       '', $availablecourseshtml);
                    break;

                case FRONTPAGECATEGORYNAMES:
                    $output .= $this->frontpage_part('skipcategories', 'frontpage-category-names',
                        get_string('categories'), $this->frontpage_categories_list());
                    break;

                case FRONTPAGECATEGORYCOMBO:
                    $output .= $this->frontpage_part('skipcourses', 'frontpage-category-combo',
                        get_string('courses'), $this->frontpage_combo_list());
                    break;

                case FRONTPAGECOURSESEARCH:
                    //$output .= $this->box($this->course_search_form(''), 'd-flex justify-content-center');
                    break;

            }
            $output .= '<br />';
        }
        return $output;
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


}
