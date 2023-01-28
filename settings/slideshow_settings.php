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
 * @package theme_competency
 * @copyright   2022 Debonair Training Ltd, debonairtraining.com
 * @author      Debonair Dev Team
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 defined('MOODLE_INTERNAL') || die();

 $page = new admin_settingpage('theme_competency_slideshow', get_string('slideshowsettings', 'theme_competency'));


 // Show hide user enrollment toggle.
 $name = 'theme_competency/showslideshow';
 $title = get_string('showslideshow', 'theme_competency');
 $description = get_string('showslideshow_desc', 'theme_competency');
 $default = 1;
 $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 // Header size setting.
 $name = 'theme_competency/slideshowpages';
 $title = get_string('slideshowpages', 'theme_competency');
 $description = get_string('slideshowpages_desc', 'theme_competency');
 $default = '0';
 $choices = array(
         '0' => get_string('slideshowpages0', 'theme_competency'),
         '1' => get_string('slideshowpages1', 'theme_competency'),
         '2' => get_string('slideshowpages2', 'theme_competency'),
     );
 $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 // Header size setting.
 $name = 'theme_competency/slideshowheight';
 $title = get_string('slideshowheight', 'theme_competency');
 $description = get_string('slideshowheight_desc', 'theme_competency');
 $default = '300px';
 $choices = array(
         '100px' => '100px',
         '125px' => '125px',
         '150px' => '150px',
         '175px' => '175px',
         '200px' => '200px',
         '225px' => '225px',
         '250px' => '250px',
         '275px' => '275px',
         '300px' => '300px',
         '325px' => '325px',
         '350px' => '350px',
         '375px' => '375px',
         '400px' => '400px',
         '425px' => '425px',
         '450px' => '450px',
         '475px' => '475px',
         '500px' => '500px',
         '525px' => '525px',
         '550px' => '550px',
         '575px' => '575px',
         '600px' => '600px',
     );
 $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 // Header size setting.
 $name = 'theme_competency/slideshowspacer';
 $title = get_string('slideshowspacer', 'theme_competency');
 $description = get_string('slideshowspacer_desc', 'theme_competency');
 $default = 'initial';
 $choices = array(
         'initial' => 'initial',
         '50px' => '50px',
         '75px' => '75px',
         '100px' => '100px',
         '125px' => '125px',
         '150px' => '150px',
         '175px' => '175px',
         '200px' => '200px',
         '225px' => '225px',
         '250px' => '250px',
         '275px' => '275px',
         '300px' => '300px',
         '325px' => '325px',
         '350px' => '350px',
         '375px' => '375px',
         '400px' => '400px',
         '425px' => '425px',
         '450px' => '450px',
         '475px' => '475px',
         '500px' => '500px',
         '525px' => '525px',
         '550px' => '550px',
         '575px' => '575px',
         '600px' => '600px',
     );
 $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 // This is the descriptor for slide
 $name = 'theme_competency/slide1info';
 $heading = get_string('slide1info', 'theme_competency');
 $information = get_string('slide1infodesc', 'theme_competency');
 $setting = new admin_setting_heading($name, $heading, $information);
 $page->add($setting);

 // Slide title
 $name = 'theme_competency/slide1title';
 $title = get_string('slidetitle', 'theme_competency');
 $description = get_string('slidetitle_desc', 'theme_competency');
 $default = '';
 $setting = new admin_setting_configtext($name, $title, $description, $default);
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 //Slide Description
 $name = 'theme_competency/slide1content';
 $title = get_string('slidecontent', 'theme_competency');
 $description = get_string('slidecontent_desc', 'theme_competency');
 $default = '';
 $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 // logo image.
 $name = 'theme_competency/slide1image';
 $title = get_string('slideimage', 'theme_competency');
 $description = get_string('slideimage_desc', 'theme_competency');
 $setting = new admin_setting_configstoredfile($name, $title, $description, 'slide1image');
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 // This is the descriptor for slide
 $name = 'theme_competency/slide2info';
 $heading = get_string('slide2info', 'theme_competency');
 $information = get_string('slide2infodesc', 'theme_competency');
 $setting = new admin_setting_heading($name, $heading, $information);
 $page->add($setting);

 // Slide title
 $name = 'theme_competency/slide2title';
 $title = get_string('slidetitle', 'theme_competency');
 $description = get_string('slidetitle_desc', 'theme_competency');
 $default = '';
 $setting = new admin_setting_configtext($name, $title, $description, $default);
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 //Slide Description
 $name = 'theme_competency/slide2content';
 $title = get_string('slidecontent', 'theme_competency');
 $description = get_string('slidecontent_desc', 'theme_competency');
 $default = '';
 $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 // logo image.
 $name = 'theme_competency/slide2image';
 $title = get_string('slideimage', 'theme_competency');
 $description = get_string('slideimage_desc', 'theme_competency');
 $setting = new admin_setting_configstoredfile($name, $title, $description, 'slide2image');
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 // This is the descriptor for slide
 $name = 'theme_competency/slide3info';
 $heading = get_string('slide3info', 'theme_competency');
 $information = get_string('slide3infodesc', 'theme_competency');
 $setting = new admin_setting_heading($name, $heading, $information);
 $page->add($setting);
 // Slide title
 $name = 'theme_competency/slide3title';
 $title = get_string('slidetitle', 'theme_competency');
 $description = get_string('slidetitle_desc', 'theme_competency');
 $default = '';
 $setting = new admin_setting_configtext($name, $title, $description, $default);
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 //Slide Description
 $name = 'theme_competency/slide3content';
 $title = get_string('slidecontent', 'theme_competency');
 $description = get_string('slidecontent_desc', 'theme_competency');
 $default = '';
 $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 // logo image.
 $name = 'theme_competency/slide3image';
 $title = get_string('slideimage', 'theme_competency');
 $description = get_string('slideimage_desc', 'theme_competency');
 $setting = new admin_setting_configstoredfile($name, $title, $description, 'slide3image');
 $setting->set_updatedcallback('theme_reset_all_caches');
 $page->add($setting);

 // Must add the page after definiting all the settings!
 $settings->add($page);
