<?php

defined('MOODLE_INTERNAL') || die();

/* Marketing Spot Settings temp*/
$page = new admin_settingpage('theme_competency_marketing', get_string('marketing', 'theme_competency'));

    // This is the descriptor for Marketing Spot One
    $name = 'theme_competency/marketing1info';
    $heading = get_string('marketing1', 'theme_competency');
    $information = get_string('marketinginfodesc', 'theme_competency');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);

    // Marketing Spot One
    $name = 'theme_competency/marketing1';
    $title = get_string('marketingtitle', 'theme_competency');
    $description = get_string('marketingtitledesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Background image setting.
    $name = 'theme_competency/marketing1image';
    $title = get_string('marketingimage', 'theme_competency');
    $description = get_string('marketingimage_desc', 'theme_competency');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing1image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing1content';
    $title = get_string('marketingcontent', 'theme_competency');
    $description = get_string('marketingcontentdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing1buttontext';
    $title = get_string('marketingbuttontext', 'theme_competency');
    $description = get_string('marketingbuttontextdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing1buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_competency');
    $description = get_string('marketingbuttonurldesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing1target';
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

    $name = 'theme_competency/marketing1icon';
    $title = get_string('marketicon','theme_competency');
    $description = get_string('marketicon_desc', 'theme_competency');
    $default = 'folder';
    $choices = array(
        'clone' => 'Clone',
        'bookmark' => 'Bookmark',
        'book' => 'Book',
        'certificate' => 'Certificate',
        'desktop' => 'Desktop',
        'graduation-cap' => 'Graduation Cap',
        'users' => 'Users',
        'bars' => 'Bars',
        'paper-plane' => 'Paper Plane',
        'plus-circle' => 'Plus Circle',
        'Sitemap' => 'Sitemap',
        'puzzle-piece' => 'Puzzle Piece',
        'spinner' => 'Spinner',
        'circle-o-notch' => 'Circle O Notch',
        'check-square-o' => 'Check Square O',
        'plus-square-o' => 'Plus Square O',
        'chevron-circle-right' => 'Chevron Circle Right',
        'arrow-circle-right' => 'Arrow Circle Right',
        'carrot-down' => 'Caret Down',
        'forward' => 'Forward',
        'file-text' => 'File Text',
        'align-right' => 'Align Right',
        'angle-double-right' => 'Angle Double Right',
        'folder-open' => 'Folder Open',
        'folder' => 'Folder',
        'folder-open-o' => 'Folder Open O',
        'chevron-right' => 'Chevron Right',
        'star' => 'Star',
        'user-circle' => 'User Circle',
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // This is the descriptor for Marketing Spot Two
    $name = 'theme_competency/marketing2info';
    $heading = get_string('marketing2', 'theme_competency');
    $information = get_string('marketinginfodesc', 'theme_competency');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);

    // Marketing Spot Two.
    $name = 'theme_competency/marketing2';
    $title = get_string('marketingtitle', 'theme_competency');
    $description = get_string('marketingtitledesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Background image setting.
    $name = 'theme_competency/marketing2image';
    $title = get_string('marketingimage', 'theme_competency');
    $description = get_string('marketingimage_desc', 'theme_competency');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing2image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing2content';
    $title = get_string('marketingcontent', 'theme_competency');
    $description = get_string('marketingcontentdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing2buttontext';
    $title = get_string('marketingbuttontext', 'theme_competency');
    $description = get_string('marketingbuttontextdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing2buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_competency');
    $description = get_string('marketingbuttonurldesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing2target';
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

    $name = 'theme_competency/marketing2icon';
    $title = get_string('marketicon','theme_competency');
    $description = get_string('marketicon_desc', 'theme_competency');
    $default = 'folder';
    $choices = array(
        'clone' => 'Clone',
        'bookmark' => 'Bookmark',
        'book' => 'Book',
        'certificate' => 'Certificate',
        'desktop' => 'Desktop',
        'graduation-cap' => 'Graduation Cap',
        'users' => 'Users',
        'bars' => 'Bars',
        'paper-plane' => 'Paper Plane',
        'plus-circle' => 'Plus Circle',
        'Sitemap' => 'Sitemap',
        'puzzle-piece' => 'Puzzle Piece',
        'spinner' => 'Spinner',
        'circle-o-notch' => 'Circle O Notch',
        'check-square-o' => 'Check Square O',
        'plus-square-o' => 'Plus Square O',
        'chevron-circle-right' => 'Chevron Circle Right',
        'arrow-circle-right' => 'Arrow Circle Right',
        'carrot-down' => 'Caret Down',
        'forward' => 'Forward',
        'file-text' => 'File Text',
        'align-right' => 'Align Right',
        'angle-double-right' => 'Angle Double Right',
        'folder-open' => 'Folder Open',
        'folder' => 'Folder',
        'folder-open-o' => 'Folder Open O',
        'chevron-right' => 'Chevron Right',
        'star' => 'Star',
        'user-circle' => 'User Circle',
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // This is the descriptor for Marketing Spot Three
    $name = 'theme_competency/marketing3info';
    $heading = get_string('marketing3', 'theme_competency');
    $information = get_string('marketinginfodesc', 'theme_competency');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);

    // Marketing Spot Three.
    $name = 'theme_competency/marketing3';
    $title = get_string('marketingtitle', 'theme_competency');
    $description = get_string('marketingtitledesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Background image setting.
    $name = 'theme_competency/marketing3image';
    $title = get_string('marketingimage', 'theme_competency');
    $description = get_string('marketingimage_desc', 'theme_competency');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing3image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing3content';
    $title = get_string('marketingcontent', 'theme_competency');
    $description = get_string('marketingcontentdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing3buttontext';
    $title = get_string('marketingbuttontext', 'theme_competency');
    $description = get_string('marketingbuttontextdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing3buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_competency');
    $description = get_string('marketingbuttonurldesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing3target';
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

    $name = 'theme_competency/marketing3icon';
    $title = get_string('marketicon','theme_competency');
    $description = get_string('marketicon_desc', 'theme_competency');
    $default = 'folder';
    $choices = array(
        'clone' => 'Clone',
        'bookmark' => 'Bookmark',
        'book' => 'Book',
        'certificate' => 'Certificate',
        'desktop' => 'Desktop',
        'graduation-cap' => 'Graduation Cap',
        'users' => 'Users',
        'bars' => 'Bars',
        'paper-plane' => 'Paper Plane',
        'plus-circle' => 'Plus Circle',
        'Sitemap' => 'Sitemap',
        'puzzle-piece' => 'Puzzle Piece',
        'spinner' => 'Spinner',
        'circle-o-notch' => 'Circle O Notch',
        'check-square-o' => 'Check Square O',
        'plus-square-o' => 'Plus Square O',
        'chevron-circle-right' => 'Chevron Circle Right',
        'arrow-circle-right' => 'Arrow Circle Right',
        'carrot-down' => 'Caret Down',
        'forward' => 'Forward',
        'file-text' => 'File Text',
        'align-right' => 'Align Right',
        'angle-double-right' => 'Angle Double Right',
        'folder-open' => 'Folder Open',
        'folder' => 'Folder',
        'folder-open-o' => 'Folder Open O',
        'chevron-right' => 'Chevron Right',
        'star' => 'Star',
        'user-circle' => 'User Circle',
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // This is the descriptor for Marketing Spot Four
    $name = 'theme_competency/marketing4info';
    $heading = get_string('marketing4', 'theme_competency');
    $information = get_string('marketinginfodesc', 'theme_competency');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);

    // Marketing Spot Four.
    $name = 'theme_competency/marketing4';
    $title = get_string('marketingtitle', 'theme_competency');
    $description = get_string('marketingtitledesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Background image setting.
    $name = 'theme_competency/marketing4image';
    $title = get_string('marketingimage', 'theme_competency');
    $description = get_string('marketingimage_desc', 'theme_competency');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing4image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing4content';
    $title = get_string('marketingcontent', 'theme_competency');
    $description = get_string('marketingcontentdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing4buttontext';
    $title = get_string('marketingbuttontext', 'theme_competency');
    $description = get_string('marketingbuttontextdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing4buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_competency');
    $description = get_string('marketingbuttonurldesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing4target';
    $title = get_string('marketingurltarget' , 'theme_competency');
    $description = get_string('marketingurltargetdesc', 'theme_competency');
    $target1 = get_string('marketingurltargetself', 'theme_competency');
    $target2 = get_string('marketingurltargetnew', 'theme_competency');
    $target4 = get_string('marketingurltargetparent', 'theme_competency');
    $default = 'target1';
    $choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target4);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing4icon';
    $title = get_string('marketicon','theme_competency');
    $description = get_string('marketicon_desc', 'theme_competency');
    $default = 'folder';
    $choices = array(
        'clone' => 'Clone',
        'bookmark' => 'Bookmark',
        'book' => 'Book',
        'certificate' => 'Certificate',
        'desktop' => 'Desktop',
        'graduation-cap' => 'Graduation Cap',
        'users' => 'Users',
        'bars' => 'Bars',
        'paper-plane' => 'Paper Plane',
        'plus-circle' => 'Plus Circle',
        'Sitemap' => 'Sitemap',
        'puzzle-piece' => 'Puzzle Piece',
        'spinner' => 'Spinner',
        'circle-o-notch' => 'Circle O Notch',
        'check-square-o' => 'Check Square O',
        'plus-square-o' => 'Plus Square O',
        'chevron-circle-right' => 'Chevron Circle Right',
        'arrow-circle-right' => 'Arrow Circle Right',
        'carrot-down' => 'Caret Down',
        'forward' => 'Forward',
        'file-text' => 'File Text',
        'align-right' => 'Align Right',
        'angle-double-right' => 'Angle Double Right',
        'folder-open' => 'Folder Open',
        'folder' => 'Folder',
        'folder-open-o' => 'Folder Open O',
        'chevron-right' => 'Chevron Right',
        'star' => 'Star',
        'user-circle' => 'User Circle',
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // This is the descriptor for Marketing Spot Five
    $name = 'theme_competency/marketing5info';
    $heading = get_string('marketing5', 'theme_competency');
    $information = get_string('marketinginfodesc', 'theme_competency');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);

    // Marketing Spot Five.
    $name = 'theme_competency/marketing5';
    $title = get_string('marketingtitle', 'theme_competency');
    $description = get_string('marketingtitledesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Background image setting.
    $name = 'theme_competency/marketing5image';
    $title = get_string('marketingimage', 'theme_competency');
    $description = get_string('marketingimage_desc', 'theme_competency');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing5image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing5content';
    $title = get_string('marketingcontent', 'theme_competency');
    $description = get_string('marketingcontentdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing5buttontext';
    $title = get_string('marketingbuttontext', 'theme_competency');
    $description = get_string('marketingbuttontextdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing5buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_competency');
    $description = get_string('marketingbuttonurldesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing5target';
    $title = get_string('marketingurltarget' , 'theme_competency');
    $description = get_string('marketingurltargetdesc', 'theme_competency');
    $target1 = get_string('marketingurltargetself', 'theme_competency');
    $target2 = get_string('marketingurltargetnew', 'theme_competency');
    $target5 = get_string('marketingurltargetparent', 'theme_competency');
    $default = 'target1';
    $choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target5);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing5icon';
    $title = get_string('marketicon','theme_competency');
    $description = get_string('marketicon_desc', 'theme_competency');
    $default = 'folder';
    $choices = array(
        'clone' => 'Clone',
        'bookmark' => 'Bookmark',
        'book' => 'Book',
        'certificate' => 'Certificate',
        'desktop' => 'Desktop',
        'graduation-cap' => 'Graduation Cap',
        'users' => 'Users',
        'bars' => 'Bars',
        'paper-plane' => 'Paper Plane',
        'plus-circle' => 'Plus Circle',
        'Sitemap' => 'Sitemap',
        'puzzle-piece' => 'Puzzle Piece',
        'spinner' => 'Spinner',
        'circle-o-notch' => 'Circle O Notch',
        'check-square-o' => 'Check Square O',
        'plus-square-o' => 'Plus Square O',
        'chevron-circle-right' => 'Chevron Circle Right',
        'arrow-circle-right' => 'Arrow Circle Right',
        'carrot-down' => 'Caret Down',
        'forward' => 'Forward',
        'file-text' => 'File Text',
        'align-right' => 'Align Right',
        'angle-double-right' => 'Angle Double Right',
        'folder-open' => 'Folder Open',
        'folder' => 'Folder',
        'folder-open-o' => 'Folder Open O',
        'chevron-right' => 'Chevron Right',
        'star' => 'Star',
        'user-circle' => 'User Circle',
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // This is the descriptor for Marketing Spot Six
    $name = 'theme_competency/marketing6info';
    $heading = get_string('marketing6', 'theme_competency');
    $information = get_string('marketinginfodesc', 'theme_competency');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);

    // Marketing Spot Six.
    $name = 'theme_competency/marketing6';
    $title = get_string('marketingtitle', 'theme_competency');
    $description = get_string('marketingtitledesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Background image setting.
    $name = 'theme_competency/marketing6image';
    $title = get_string('marketingimage', 'theme_competency');
    $description = get_string('marketingimage_desc', 'theme_competency');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing6image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing6content';
    $title = get_string('marketingcontent', 'theme_competency');
    $description = get_string('marketingcontentdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing6buttontext';
    $title = get_string('marketingbuttontext', 'theme_competency');
    $description = get_string('marketingbuttontextdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing6buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_competency');
    $description = get_string('marketingbuttonurldesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing6target';
    $title = get_string('marketingurltarget' , 'theme_competency');
    $description = get_string('marketingurltargetdesc', 'theme_competency');
    $target1 = get_string('marketingurltargetself', 'theme_competency');
    $target2 = get_string('marketingurltargetnew', 'theme_competency');
    $target6 = get_string('marketingurltargetparent', 'theme_competency');
    $default = 'target1';
    $choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target6);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing6icon';
    $title = get_string('marketicon','theme_competency');
    $description = get_string('marketicon_desc', 'theme_competency');
    $default = 'folder';
    $choices = array(
        'clone' => 'Clone',
        'bookmark' => 'Bookmark',
        'book' => 'Book',
        'certificate' => 'Certificate',
        'desktop' => 'Desktop',
        'graduation-cap' => 'Graduation Cap',
        'users' => 'Users',
        'bars' => 'Bars',
        'paper-plane' => 'Paper Plane',
        'plus-circle' => 'Plus Circle',
        'Sitemap' => 'Sitemap',
        'puzzle-piece' => 'Puzzle Piece',
        'spinner' => 'Spinner',
        'circle-o-notch' => 'Circle O Notch',
        'check-square-o' => 'Check Square O',
        'plus-square-o' => 'Plus Square O',
        'chevron-circle-right' => 'Chevron Circle Right',
        'arrow-circle-right' => 'Arrow Circle Right',
        'carrot-down' => 'Caret Down',
        'forward' => 'Forward',
        'file-text' => 'File Text',
        'align-right' => 'Align Right',
        'angle-double-right' => 'Angle Double Right',
        'folder-open' => 'Folder Open',
        'folder' => 'Folder',
        'folder-open-o' => 'Folder Open O',
        'chevron-right' => 'Chevron Right',
        'star' => 'Star',
        'user-circle' => 'User Circle',
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // This is the descriptor for Marketing Spot Seven
    $name = 'theme_competency/marketing7info';
    $heading = get_string('marketing7', 'theme_competency');
    $information = get_string('marketinginfodesc', 'theme_competency');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);

    // Marketing Spot Seven.
    $name = 'theme_competency/marketing7';
    $title = get_string('marketingtitle', 'theme_competency');
    $description = get_string('marketingtitledesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Background image setting.
    $name = 'theme_competency/marketing7image';
    $title = get_string('marketingimage', 'theme_competency');
    $description = get_string('marketingimage_desc', 'theme_competency');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing7image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing7content';
    $title = get_string('marketingcontent', 'theme_competency');
    $description = get_string('marketingcontentdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing7buttontext';
    $title = get_string('marketingbuttontext', 'theme_competency');
    $description = get_string('marketingbuttontextdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing7buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_competency');
    $description = get_string('marketingbuttonurldesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing7target';
    $title = get_string('marketingurltarget' , 'theme_competency');
    $description = get_string('marketingurltargetdesc', 'theme_competency');
    $target1 = get_string('marketingurltargetself', 'theme_competency');
    $target2 = get_string('marketingurltargetnew', 'theme_competency');
    $target7 = get_string('marketingurltargetparent', 'theme_competency');
    $default = 'target1';
    $choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target7);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing7icon';
    $title = get_string('marketicon','theme_competency');
    $description = get_string('marketicon_desc', 'theme_competency');
    $default = 'folder';
    $choices = array(
        'clone' => 'Clone',
        'bookmark' => 'Bookmark',
        'book' => 'Book',
        'certificate' => 'Certificate',
        'desktop' => 'Desktop',
        'graduation-cap' => 'Graduation Cap',
        'users' => 'Users',
        'bars' => 'Bars',
        'paper-plane' => 'Paper Plane',
        'plus-circle' => 'Plus Circle',
        'Sitemap' => 'Sitemap',
        'puzzle-piece' => 'Puzzle Piece',
        'spinner' => 'Spinner',
        'circle-o-notch' => 'Circle O Notch',
        'check-square-o' => 'Check Square O',
        'plus-square-o' => 'Plus Square O',
        'chevron-circle-right' => 'Chevron Circle Right',
        'arrow-circle-right' => 'Arrow Circle Right',
        'carrot-down' => 'Caret Down',
        'forward' => 'Forward',
        'file-text' => 'File Text',
        'align-right' => 'Align Right',
        'angle-double-right' => 'Angle Double Right',
        'folder-open' => 'Folder Open',
        'folder' => 'Folder',
        'folder-open-o' => 'Folder Open O',
        'chevron-right' => 'Chevron Right',
        'star' => 'Star',
        'user-circle' => 'User Circle',
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // This is the descriptor for Marketing Spot Eight
    $name = 'theme_competency/marketing8info';
    $heading = get_string('marketing8', 'theme_competency');
    $information = get_string('marketinginfodesc', 'theme_competency');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);

    // Marketing Spot Eight.
    $name = 'theme_competency/marketing8';
    $title = get_string('marketingtitle', 'theme_competency');
    $description = get_string('marketingtitledesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Background image setting.
    $name = 'theme_competency/marketing8image';
    $title = get_string('marketingimage', 'theme_competency');
    $description = get_string('marketingimage_desc', 'theme_competency');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing8image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing8content';
    $title = get_string('marketingcontent', 'theme_competency');
    $description = get_string('marketingcontentdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing8buttontext';
    $title = get_string('marketingbuttontext', 'theme_competency');
    $description = get_string('marketingbuttontextdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing8buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_competency');
    $description = get_string('marketingbuttonurldesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing8target';
    $title = get_string('marketingurltarget' , 'theme_competency');
    $description = get_string('marketingurltargetdesc', 'theme_competency');
    $target1 = get_string('marketingurltargetself', 'theme_competency');
    $target2 = get_string('marketingurltargetnew', 'theme_competency');
    $target8 = get_string('marketingurltargetparent', 'theme_competency');
    $default = 'target1';
    $choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target8);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing8icon';
    $title = get_string('marketicon','theme_competency');
    $description = get_string('marketicon_desc', 'theme_competency');
    $default = 'folder';
    $choices = array(
        'clone' => 'Clone',
        'bookmark' => 'Bookmark',
        'book' => 'Book',
        'certificate' => 'Certificate',
        'desktop' => 'Desktop',
        'graduation-cap' => 'Graduation Cap',
        'users' => 'Users',
        'bars' => 'Bars',
        'paper-plane' => 'Paper Plane',
        'plus-circle' => 'Plus Circle',
        'Sitemap' => 'Sitemap',
        'puzzle-piece' => 'Puzzle Piece',
        'spinner' => 'Spinner',
        'circle-o-notch' => 'Circle O Notch',
        'check-square-o' => 'Check Square O',
        'plus-square-o' => 'Plus Square O',
        'chevron-circle-right' => 'Chevron Circle Right',
        'arrow-circle-right' => 'Arrow Circle Right',
        'carrot-down' => 'Caret Down',
        'forward' => 'Forward',
        'file-text' => 'File Text',
        'align-right' => 'Align Right',
        'angle-double-right' => 'Angle Double Right',
        'folder-open' => 'Folder Open',
        'folder' => 'Folder',
        'folder-open-o' => 'Folder Open O',
        'chevron-right' => 'Chevron Right',
        'star' => 'Star',
        'user-circle' => 'User Circle',
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // This is the descriptor for Marketing Spot Nine
    $name = 'theme_competency/marketing9info';
    $heading = get_string('marketing9', 'theme_competency');
    $information = get_string('marketinginfodesc', 'theme_competency');
    $setting = new admin_setting_heading($name, $heading, $information);
    $page->add($setting);

    // Marketing Spot Nine.
    $name = 'theme_competency/marketing9';
    $title = get_string('marketingtitle', 'theme_competency');
    $description = get_string('marketingtitledesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Background image setting.
    $name = 'theme_competency/marketing9image';
    $title = get_string('marketingimage', 'theme_competency');
    $description = get_string('marketingimage_desc', 'theme_competency');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing9image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing9content';
    $title = get_string('marketingcontent', 'theme_competency');
    $description = get_string('marketingcontentdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing9buttontext';
    $title = get_string('marketingbuttontext', 'theme_competency');
    $description = get_string('marketingbuttontextdesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing9buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_competency');
    $description = get_string('marketingbuttonurldesc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing9target';
    $title = get_string('marketingurltarget' , 'theme_competency');
    $description = get_string('marketingurltargetdesc', 'theme_competency');
    $target1 = get_string('marketingurltargetself', 'theme_competency');
    $target2 = get_string('marketingurltargetnew', 'theme_competency');
    $target9 = get_string('marketingurltargetparent', 'theme_competency');
    $default = 'target1';
    $choices = array('_self'=>$target1, '_blank'=>$target2, '_parent'=>$target9);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/marketing9icon';
    $title = get_string('marketicon','theme_competency');
    $description = get_string('marketicon_desc', 'theme_competency');
    $default = 'folder';
    $choices = array(
        'clone' => 'Clone',
        'bookmark' => 'Bookmark',
        'book' => 'Book',
        'certificate' => 'Certificate',
        'desktop' => 'Desktop',
        'graduation-cap' => 'Graduation Cap',
        'users' => 'Users',
        'bars' => 'Bars',
        'paper-plane' => 'Paper Plane',
        'plus-circle' => 'Plus Circle',
        'Sitemap' => 'Sitemap',
        'puzzle-piece' => 'Puzzle Piece',
        'spinner' => 'Spinner',
        'circle-o-notch' => 'Circle O Notch',
        'check-square-o' => 'Check Square O',
        'plus-square-o' => 'Plus Square O',
        'chevron-circle-right' => 'Chevron Circle Right',
        'arrow-circle-right' => 'Arrow Circle Right',
        'carrot-down' => 'Caret Down',
        'forward' => 'Forward',
        'file-text' => 'File Text',
        'align-right' => 'Align Right',
        'angle-double-right' => 'Angle Double Right',
        'folder-open' => 'Folder Open',
        'folder' => 'Folder',
        'folder-open-o' => 'Folder Open O',
        'chevron-right' => 'Chevron Right',
        'star' => 'Star',
        'user-circle' => 'User Circle',
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
