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
* Social networking settings page file.
*
* @package     theme_competency
* @copyright   2022 Debonair Training Ltd, debonairtraining.com
* @author      Debonair Dev Team
* @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

defined('MOODLE_INTERNAL') || die();

/* Social Network Settings */
$page = new admin_settingpage('theme_competency_footer', get_string('footerheading', 'theme_competency'));
$page->add(new admin_setting_heading('theme_competency_footer', get_string('footerheadingsub', 'theme_competency'), format_text(get_string('footerdesc' , 'theme_competency'), FORMAT_MARKDOWN)));

// footer branding
$name = 'theme_competency/brandorganization';
$title = get_string('brandorganization', 'theme_competency');
$description = get_string('brandorganizationdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// footer branding
$name = 'theme_competency/brandwebsite';
$title = get_string('brandwebsite', 'theme_competency');
$description = get_string('brandwebsitedesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// footer branding
$name = 'theme_competency/brandphone';
$title = get_string('brandphone', 'theme_competency');
$description = get_string('brandphonedesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// footer branding
$name = 'theme_competency/brandemail';
$title = get_string('brandemail', 'theme_competency');
$description = get_string('brandemaildesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Footnote setting.
$name = 'theme_competency/footnote';
$title = get_string('footnote', 'theme_competency');
$description = get_string('footnotedesc', 'theme_competency');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);


// This is the descriptor for socialicons
$name = 'theme_competency/socialiconsinfo';
$heading = get_string('footerheadingsocial', 'theme_competency');
$information = get_string('footerdesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Website url setting.
$name = 'theme_competency/website';
$title = get_string('website', 'theme_competency');
$description = get_string('websitedesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Blog url setting.
$name = 'theme_competency/blog';
$title = get_string('blog', 'theme_competency');
$description = get_string('blogdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Facebook url setting.
$name = 'theme_competency/facebook';
$title = get_string(        'facebook', 'theme_competency');
$description = get_string(      'facebookdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Flickr url setting.
$name = 'theme_competency/flickr';
$title = get_string('flickr', 'theme_competency');
$description = get_string('flickrdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Twitter url setting.
$name = 'theme_competency/twitter';
$title = get_string('twitter', 'theme_competency');
$description = get_string('twitterdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Google+ url setting.
$name = 'theme_competency/googleplus';
$title = get_string('googleplus', 'theme_competency');
$description = get_string('googleplusdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// LinkedIn url setting.
$name = 'theme_competency/linkedin';
$title = get_string('linkedin', 'theme_competency');
$description = get_string('linkedindesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Tumblr url setting.
$name = 'theme_competency/tumblr';
$title = get_string('tumblr', 'theme_competency');
$description = get_string('tumblrdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Pinterest url setting.
$name = 'theme_competency/pinterest';
$title = get_string('pinterest', 'theme_competency');
$description = get_string('pinterestdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Instagram url setting.
$name = 'theme_competency/instagram';
$title = get_string('instagram', 'theme_competency');
$description = get_string('instagramdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// YouTube url setting.
$name = 'theme_competency/youtube';
$title = get_string('youtube', 'theme_competency');
$description = get_string('youtubedesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Vimeo url setting.
$name = 'theme_competency/vimeo';
$title = get_string('vimeo', 'theme_competency');
$description = get_string('vimeodesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Skype url setting.
$name = 'theme_competency/skype';
$title = get_string('skype', 'theme_competency');
$description = get_string('skypedesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// General social url setting 1.
$name = 'theme_competency/social1';
$title = get_string('sociallink', 'theme_competency');
$description = get_string('sociallinkdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Social icon setting 1.
$name = 'theme_competency/socialicon1';
$title = get_string('sociallinkicon', 'theme_competency');
$description = get_string('sociallinkicondesc', 'theme_competency');
$default = 'home';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$page->add($setting);

// General social url setting 2.
$name = 'theme_competency/social2';
$title = get_string('sociallink', 'theme_competency');
$description = get_string('sociallinkdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Social icon setting 2.
$name = 'theme_competency/socialicon2';
$title = get_string('sociallinkicon', 'theme_competency');
$description = get_string('sociallinkicondesc', 'theme_competency');
$default = 'home';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$page->add($setting);

// General social url setting 3.
$name = 'theme_competency/social3';
$title = get_string('sociallink', 'theme_competency');
$description = get_string('sociallinkdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Social icon setting 3.
$name = 'theme_competency/socialicon3';
$title = get_string('sociallinkicon', 'theme_competency');
$description = get_string('sociallinkicondesc', 'theme_competency');
$default = 'home';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$page->add($setting);

// Must add the page after definiting all the settings!
$settings->add($page);
