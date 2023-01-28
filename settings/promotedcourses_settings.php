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
* Heading and course images settings page file.
*
* @package     theme_competency
* @copyright   2022 Debonair Training Ltd, debonairtraining.com
* @author      Debonair Dev Team
* @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

defined('MOODLE_INTERNAL') || die();

$page = new admin_settingpage('theme_competency_promoted', get_string('promoted_courses', 'theme_competency'));

// Promoted Courses Start.
    // Promoted Courses Heading.
    $name = 'theme_competency_promotedcoursesheading';
    $heading = get_string('promotedcoursesheading', 'theme_competency');
    $information = '';
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Enable / Disable Promoted Courses.
    $name = 'theme_competency/pcourseenable';
    $title = get_string('pcourseenable', 'theme_competency');
    $description = '';
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $temp->add($setting);

    // Promoted courses Block title.
    $name = 'theme_competency/promotedtitle';
    $title = get_string('pcourses', 'theme_competency').' '.get_string('title', 'theme_competency');
    $description = get_string('promotedtitledesc', 'theme_competency');
    $default = 'lang:promotedtitledefault';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_competency/promotedcourses';
    $title = get_string('pcourses', 'theme_competency');
    $description = get_string('pcoursesdesc', 'theme_competency');
    $default = array();

    $courses[0] = '';
    $cnt = 0;
    if ($ccc = get_courses('all', 'c.sortorder ASC', 'c.id,c.shortname,c.visible,c.category')) {
        foreach ($ccc as $cc) {
            if ($cc->visible == "0" || $cc->id == "1") {
                continue;
            }
            $cnt++;
            $courses[$cc->id] = $cc->shortname;
            // Set some courses for default option.
            if ($cnt < 8) {
                $default[] = $cc->id;
            }
        }
    }
    $coursedefault = implode(",", $default);
    $setting = new admin_setting_configtextarea($name, $title, $description, $coursedefault);
    $temp->add($setting);

    // Must add the page after definiting all the settings!
    $settings->add($page);
