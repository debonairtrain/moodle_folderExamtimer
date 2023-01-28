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

// Icon Navigation);
$page = new admin_settingpage('theme_competency_iconnavheading', get_string('iconnavheading', 'theme_competency'));

// This is the descriptor for icon One
$name = 'theme_competency/iconwidthinfo';
$heading = get_string('iconwidthinfo', 'theme_competency');
$information = get_string('iconwidthinfodesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Icon width setting.
$name = 'theme_competency/iconwidth';
$title = get_string('iconwidth', 'theme_competency');
$description = get_string('iconwidth_desc', 'theme_competency');;
$default = '100px';
$choices = array(
    '75px' => '75px',
    '85px' => '85px',
    '95px' => '95px',
    '100px' => '100px',
    '105px' => '105px',
    '110px' => '110px',
    '115px' => '115px',
    '120px' => '120px',
    '125px' => '125px',
    '130px' => '130px',
    '135px' => '135px',
    '140px' => '140px',
    '145px' => '145px',
    '150px' => '150px',
);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for teacher create a course
$name = 'theme_competency/createinfo';
$heading = get_string('createinfo', 'theme_competency');
$information = get_string('createinfodesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Creator Icon
$name = 'theme_competency/createicon';
$title = get_string('navicon', 'theme_competency');
$description = get_string('navicondesc', 'theme_competency');
$default = 'edit';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/createbuttontext';
$title = get_string('naviconbuttontext', 'theme_competency');
$description = get_string('naviconbuttontextdesc', 'theme_competency');
$default = get_string('naviconbuttoncreatetextdefault', 'theme_competency');
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/createbuttonurl';
$title = get_string('naviconbuttonurl', 'theme_competency');
$description = get_string('naviconbuttonurldesc', 'theme_competency');
$default =  $CFG->wwwroot.'/course/edit.php?category=1';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for teacher create a course
$name = 'theme_competency/sliderinfo';
$heading = get_string('sliderinfo', 'theme_competency');
$information = get_string('sliderinfodesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// Creator Icon
$name = 'theme_competency/slideicon';
$title = get_string('navicon', 'theme_competency');
$description = get_string('naviconslidedesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/slideiconbuttontext';
$title = get_string('naviconbuttontext', 'theme_competency');
$description = get_string('naviconbuttontextdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Slide Textbox.
$name = 'theme_competency/slidetextbox';
$title = get_string('slidetextbox', 'theme_competency');
$description = get_string('slidetextbox_desc', 'theme_competency');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for icon One
$name = 'theme_competency/navicon1info';
$heading = get_string('navicon1', 'theme_competency');
$information = get_string('navicondesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// icon One
$name = 'theme_competency/nav1icon';
$title = get_string('navicon', 'theme_competency');
$description = get_string('navicondesc', 'theme_competency');
$default = 'thermometer-full';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav1buttontext';
$title = get_string('naviconbuttontext', 'theme_competency');
$description = get_string('naviconbuttontextdesc', 'theme_competency');
$default = get_string('naviconbutton1textdefault', 'theme_competency');
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav1buttonurl';
$title = get_string('naviconbuttonurl', 'theme_competency');
$description = get_string('naviconbuttonurldesc', 'theme_competency');
$default =  $CFG->wwwroot.'/my/';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav1target';
$title = get_string('marketingurltarget' , 'theme_competency');
$description = get_string('marketingurltargetdesc', 'theme_competency');
$target1 = get_string('marketingurltargetself', 'theme_competency');
$target2 = get_string('marketingurltargetnew', 'theme_competency');
$target3 = get_string('marketingurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for icon One
$name = 'theme_competency/navicon2info';
$heading = get_string('navicon2', 'theme_competency');
$information = get_string('navicondesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

$name = 'theme_competency/nav2icon';
$title = get_string('navicon', 'theme_competency');
$description = get_string('navicondesc', 'theme_competency');
$default = 'clock-o';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav2buttontext';
$title = get_string('naviconbuttontext', 'theme_competency');
$description = get_string('naviconbuttontextdesc', 'theme_competency');
$default = get_string('naviconbutton2textdefault', 'theme_competency');
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav2buttonurl';
$title = get_string('naviconbuttonurl', 'theme_competency');
$description = get_string('naviconbuttonurldesc', 'theme_competency');
$default =  $CFG->wwwroot.'/calendar/view.php?view=month';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav2target';
$title = get_string('marketingurltarget' , 'theme_competency');
$description = get_string('marketingurltargetdesc', 'theme_competency');
$target1 = get_string('marketingurltargetself', 'theme_competency');
$target2 = get_string('marketingurltargetnew', 'theme_competency');
$target3 = get_string('marketingurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for icon three
$name = 'theme_competency/navicon3info';
$heading = get_string('navicon3', 'theme_competency');
$information = get_string('navicondesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

$name = 'theme_competency/nav3icon';
$title = get_string('navicon', 'theme_competency');
$description = get_string('navicondesc', 'theme_competency');
$default = 'graduation-cap';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav3buttontext';
$title = get_string('naviconbuttontext', 'theme_competency');
$description = get_string('naviconbuttontextdesc', 'theme_competency');
$default = get_string('naviconbutton3textdefault', 'theme_competency');
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav3buttonurl';
$title = get_string('naviconbuttonurl', 'theme_competency');
$description = get_string('naviconbuttonurldesc', 'theme_competency');
$default =  $CFG->wwwroot.'/badges/mybadges.php';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav3target';
$title = get_string('marketingurltarget' , 'theme_competency');
$description = get_string('marketingurltargetdesc', 'theme_competency');
$target1 = get_string('marketingurltargetself', 'theme_competency');
$target2 = get_string('marketingurltargetnew', 'theme_competency');
$target3 = get_string('marketingurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for icon four
$name = 'theme_competency/navicon4info';
$heading = get_string('navicon4', 'theme_competency');
$information = get_string('navicondesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

$name = 'theme_competency/nav4icon';
$title = get_string('navicon', 'theme_competency');
$description = get_string('navicondesc', 'theme_competency');
$default = 'certificate';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav4buttontext';
$title = get_string('naviconbuttontext', 'theme_competency');
$description = get_string('naviconbuttontextdesc', 'theme_competency');
$default = get_string('naviconbutton4textdefault', 'theme_competency');
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav4buttonurl';
$title = get_string('naviconbuttonurl', 'theme_competency');
$description = get_string('naviconbuttonurldesc', 'theme_competency');
$default =  $CFG->wwwroot.'/course/';
$setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav4target';
$title = get_string('marketingurltarget' , 'theme_competency');
$description = get_string('marketingurltargetdesc', 'theme_competency');
$target1 = get_string('marketingurltargetself', 'theme_competency');
$target2 = get_string('marketingurltargetnew', 'theme_competency');
$target3 = get_string('marketingurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for icon four
$name = 'theme_competency/navicon5info';
$heading = get_string('navicon5', 'theme_competency');
$information = get_string('navicondesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

$name = 'theme_competency/nav5icon';
$title = get_string('navicon', 'theme_competency');
$description = get_string('navicondesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav5buttontext';
$title = get_string('naviconbuttontext', 'theme_competency');
$description = get_string('naviconbuttontextdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav5buttonurl';
$title = get_string('naviconbuttonurl', 'theme_competency');
$description = get_string('naviconbuttonurldesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav5target';
$title = get_string('marketingurltarget' , 'theme_competency');
$description = get_string('marketingurltargetdesc', 'theme_competency');
$target1 = get_string('marketingurltargetself', 'theme_competency');
$target2 = get_string('marketingurltargetnew', 'theme_competency');
$target3 = get_string('marketingurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for icon six
$name = 'theme_competency/navicon6info';
$heading = get_string('navicon6', 'theme_competency');
$information = get_string('navicondesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

$name = 'theme_competency/nav6icon';
$title = get_string('navicon', 'theme_competency');
$description = get_string('navicondesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav6buttontext';
$title = get_string('naviconbuttontext', 'theme_competency');
$description = get_string('naviconbuttontextdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav6buttonurl';
$title = get_string('naviconbuttonurl', 'theme_competency');
$description = get_string('naviconbuttonurldesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav6target';
$title = get_string('marketingurltarget' , 'theme_competency');
$description = get_string('marketingurltargetdesc', 'theme_competency');
$target1 = get_string('marketingurltargetself', 'theme_competency');
$target2 = get_string('marketingurltargetnew', 'theme_competency');
$target3 = get_string('marketingurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for icon seven
$name = 'theme_competency/navicon7info';
$heading = get_string('navicon7', 'theme_competency');
$information = get_string('navicondesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

$name = 'theme_competency/nav7icon';
$title = get_string('navicon', 'theme_competency');
$description = get_string('navicondesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav7buttontext';
$title = get_string('naviconbuttontext', 'theme_competency');
$description = get_string('naviconbuttontextdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav7buttonurl';
$title = get_string('naviconbuttonurl', 'theme_competency');
$description = get_string('naviconbuttonurldesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav7target';
$title = get_string('marketingurltarget' , 'theme_competency');
$description = get_string('marketingurltargetdesc', 'theme_competency');
$target1 = get_string('marketingurltargetself', 'theme_competency');
$target2 = get_string('marketingurltargetnew', 'theme_competency');
$target3 = get_string('marketingurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for icon eight
$name = 'theme_competency/navicon8info';
$heading = get_string('navicon8', 'theme_competency');
$information = get_string('navicondesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

$name = 'theme_competency/nav8icon';
$title = get_string('navicon', 'theme_competency');
$description = get_string('navicondesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav8buttontext';
$title = get_string('naviconbuttontext', 'theme_competency');
$description = get_string('naviconbuttontextdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav8buttonurl';
$title = get_string('naviconbuttonurl', 'theme_competency');
$description = get_string('naviconbuttonurldesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/nav8target';
$title = get_string('marketingurltarget' , 'theme_competency');
$description = get_string('marketingurltargetdesc', 'theme_competency');
$target1 = get_string('marketingurltargetself', 'theme_competency');
$target2 = get_string('marketingurltargetnew', 'theme_competency');
$target3 = get_string('marketingurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Must add the page after definiting all the settings!
$settings->add($page);
