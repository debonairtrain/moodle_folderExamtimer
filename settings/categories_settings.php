<?php

defined('MOODLE_INTERNAL') || die();

/* category Spot Settings temp*/
$page = new admin_settingpage('theme_competency_categories', get_string('categoriesheading', 'theme_competency'));

// Toggle FP Textbox Spots.
$name = 'theme_competency/togglecategory';
$title = get_string('togglecategory' , 'theme_competency');
$description = get_string('togglecategory_desc', 'theme_competency');
$displaytop = get_string('displaytop', 'theme_competency');
$displaybottom = get_string('displaybottom', 'theme_competency');
$default = '1';
$choices = array('1'=>$displaytop, '2'=>$displaybottom);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for category Spot One
$name = 'theme_competency/category1info';
$heading = get_string('category1', 'theme_competency');
$information = get_string('categoryinfodesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// category Spot One
$name = 'theme_competency/category1';
$title = get_string('categorytitle', 'theme_competency');
$description = get_string('categorytitledesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Background image setting.
$name = 'theme_competency/category1image';
$title = get_string('categoryimage', 'theme_competency');
$description = get_string('categoryimage_desc', 'theme_competency');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'category1image');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category1content';
$title = get_string('categorycontent', 'theme_competency');
$description = get_string('categorycontentdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category1buttontext';
$title = get_string('categorybuttontext', 'theme_competency');
$description = get_string('categorybuttontextdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category1buttonurl';
$title = get_string('categorybuttonurl', 'theme_competency');
$description = get_string('categorybuttonurldesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category1target';
$title = get_string('categoryurltarget' , 'theme_competency');
$description = get_string('categoryurltargetdesc', 'theme_competency');
$target1 = get_string('categoryurltargetself', 'theme_competency');
$target2 = get_string('categoryurltargetnew', 'theme_competency');
$target3 = get_string('categoryurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for category Spot Two
$name = 'theme_competency/category2info';
$heading = get_string('category2', 'theme_competency');
$information = get_string('categoryinfodesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// category Spot Two.
$name = 'theme_competency/category2';
$title = get_string('categorytitle', 'theme_competency');
$description = get_string('categorytitledesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Background image setting.
$name = 'theme_competency/category2image';
$title = get_string('categoryimage', 'theme_competency');
$description = get_string('categoryimage_desc', 'theme_competency');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'category2image');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category2content';
$title = get_string('categorycontent', 'theme_competency');
$description = get_string('categorycontentdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category2buttontext';
$title = get_string('categorybuttontext', 'theme_competency');
$description = get_string('categorybuttontextdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category2buttonurl';
$title = get_string('categorybuttonurl', 'theme_competency');
$description = get_string('categorybuttonurldesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category2target';
$title = get_string('categoryurltarget' , 'theme_competency');
$description = get_string('categoryurltargetdesc', 'theme_competency');
$target1 = get_string('categoryurltargetself', 'theme_competency');
$target2 = get_string('categoryurltargetnew', 'theme_competency');
$target3 = get_string('categoryurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for category Spot Three
$name = 'theme_competency/category3info';
$heading = get_string('category3', 'theme_competency');
$information = get_string('categoryinfodesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// category Spot Three.
$name = 'theme_competency/category3';
$title = get_string('categorytitle', 'theme_competency');
$description = get_string('categorytitledesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Background image setting.
$name = 'theme_competency/category3image';
$title = get_string('categoryimage', 'theme_competency');
$description = get_string('categoryimage_desc', 'theme_competency');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'category3image');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category3content';
$title = get_string('categorycontent', 'theme_competency');
$description = get_string('categorycontentdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category3buttontext';
$title = get_string('categorybuttontext', 'theme_competency');
$description = get_string('categorybuttontextdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category3buttonurl';
$title = get_string('categorybuttonurl', 'theme_competency');
$description = get_string('categorybuttonurldesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category3target';
$title = get_string('categoryurltarget' , 'theme_competency');
$description = get_string('categoryurltargetdesc', 'theme_competency');
$target1 = get_string('categoryurltargetself', 'theme_competency');
$target2 = get_string('categoryurltargetnew', 'theme_competency');
$target3 = get_string('categoryurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// This is the descriptor for category Spot Four
$name = 'theme_competency/category4info';
$heading = get_string('category4', 'theme_competency');
$information = get_string('categoryinfodesc', 'theme_competency');
$setting = new admin_setting_heading($name, $heading, $information);
$page->add($setting);

// category Spot
$name = 'theme_competency/category4';
$title = get_string('categorytitle', 'theme_competency');
$description = get_string('categorytitledesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Background image setting.
$name = 'theme_competency/category4image';
$title = get_string('categoryimage', 'theme_competency');
$description = get_string('categoryimage_desc', 'theme_competency');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'category4image');
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category4content';
$title = get_string('categorycontent', 'theme_competency');
$description = get_string('categorycontentdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category4buttontext';
$title = get_string('categorybuttontext', 'theme_competency');
$description = get_string('categorybuttontextdesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category4buttonurl';
$title = get_string('categorybuttonurl', 'theme_competency');
$description = get_string('categorybuttonurldesc', 'theme_competency');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$name = 'theme_competency/category4target';
$title = get_string('categoryurltarget' , 'theme_competency');
$description = get_string('categoryurltargetdesc', 'theme_competency');
$target1 = get_string('categoryurltargetself', 'theme_competency');
$target2 = get_string('categoryurltargetnew', 'theme_competency');
$target3 = get_string('categoryurltargetparent', 'theme_competency');
$default = 'target1';
$choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target3);
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);


// Must add the page after definiting all the settings!
$settings->add($page);
