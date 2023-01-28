<?php

defined('MOODLE_INTERNAL') || die();

/* category Spot Settings temp*/
    $page = new admin_settingpage('theme_competency_general', get_string('generalsettings', 'theme_boost'));

    // Unaddable blocks.
    // Blocks to be excluded when this theme is enabled in the "Add a block" list: Administration, Navigation, Courses and
    // Section links.
    $default = 'navigation,settings,course_list,section_links';
    $setting = new admin_setting_configtext('theme_competency/unaddableblocks',
            get_string('unaddableblocks', 'theme_boost'), get_string('unaddableblocks_desc', 'theme_boost'), $default, PARAM_TEXT);
    $page->add($setting);

    // Preset.
    $name = 'theme_competency/preset';
    $title = get_string('preset', 'theme_boost');
    $description = get_string('preset_desc', 'theme_boost');
    $default = 'default.scss';

    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_competency', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets.
    $choices['default.scss'] = 'default.scss';

    $setting = new admin_setting_configthemepreset($name, $title, $description, $default, $choices, 'competency');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_competency/presetfiles';
    $title = get_string('presetfiles', 'theme_boost');
    $description = get_string('presetfiles_desc', 'theme_boost');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
            array('maxfiles' => 20, 'accepted_types' => array('.scss')));
    $page->add($setting);

    // Sections Display Options.
    $name = 'theme_competency/sectionstyle';
    $title = get_string('sectionstyle' , 'theme_competency');
    $description = get_string('sectionstyle_desc', 'theme_competency');
    $option1 = get_string('sections-competency', 'theme_competency');
    $option2 = get_string('sections-boxed', 'theme_competency');
    $option3 = get_string('sections-boost', 'theme_competency');
    $option4 = get_string('sections-bars', 'theme_competency');
    $default = '1';
    $choices = array('1'=>$option1, '2'=>$option2, '3'=>$option3, '4'=>$option4);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/fullwidthpage';
    $title = get_string('fullwidthpage', 'theme_competency');
    $description = get_string('fullwidthpage_desc', 'theme_competency');
    $default = '1';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Show/hide course index navigation.
    $name = 'theme_competency/showcourseindexnav';
    $title = get_string('showcourseindexnav', 'theme_competency');
    $description = get_string('showcourseindexnav_desc', 'theme_competency');
    $default = '1';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Show/hide course index navigation.
    $name = 'theme_competency/showblockdrawer';
    $title = get_string('showblockdrawer', 'theme_competency');
    $description = get_string('showblockdrawer_desc', 'theme_competency');
    $default = '1';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Block Display Options.
    $name = 'theme_competency/activitynavdisplay';
    $title = get_string('activitynavdisplay' , 'theme_competency');
    $description = get_string('activitynavdisplay_desc', 'theme_competency');
    //$option1 = get_string('blockdisplay_on', 'theme_competency');
    $option1 = get_string('actnav_top_on', 'theme_competency');
    $option2 = get_string('actnav_bottom_on', 'theme_competency');
    $option3 = get_string('actnav_all_on', 'theme_competency');
    $option4 = get_string('actnav_all_off', 'theme_competency');
    $default = '1';
    $choices = array('1'=>$option1, '2'=>$option2, '3'=>$option3, '4'=>$option4);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    //Activity icon size for course page.
    $name = 'theme_competency/courseiconsize';
    $title = get_string('courseiconsize', 'theme_competency');
    $description = get_string('courseiconsize_desc', 'theme_competency');;
    $default = '50px';
    $choices = array(
            '26px' => '26px',
            '28px' => '28px',
            '30px' => '30px',
            '32px' => '32px',
            '34px' => '34px',
            '36px' => '36px',
            '38px' => '38px',
            '40px' => '40px',
            '42px' => '42px',
            '44px' => '44px',
            '46px' => '46px',
            '48px' => '48px',
            '50px' => '50px',
            '52px' => '52px',
            '54px' => '54px',
            '56px' => '56px',
            '58px' => '58px',
            '60px' => '60px',
        );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Show/hide course index navigation.
    $name = 'theme_competency/showheaderblockpanel';
    $title = get_string('showheaderblockpanel', 'theme_competency');
    $description = get_string('showheaderblockpanel_desc', 'theme_competency');
    $default = '1';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Show/hide page image.
    $name = 'theme_competency/showpageimage';
    $title = get_string('showpageimage', 'theme_competency');
    $description = get_string('showpageimage_desc', 'theme_competency');
    $default = '1';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/showheaderblocks';
    $title = get_string('showheaderblocks', 'theme_competency');
    $description = get_string('showheaderblocks_desc', 'theme_competency');
    $default = '1';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Show sitewide image.
    $name = 'theme_competency/sitewideimage';
    $title = get_string('sitewideimage', 'theme_competency');
    $description = get_string('sitewideimage_desc', 'theme_competency');
    $default = '';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/showfooterblocks';
    $title = get_string('showfooterblocks', 'theme_competency');
    $description = get_string('showfooterblocks_desc', 'theme_competency');
    $default = '1';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Background image setting.
    $name = 'theme_competency/pagebackgroundimage';
    $title = get_string('backgroundimage', 'theme_competency');
    $description = get_string('backgroundimage_desc', 'theme_competency');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'pagebackgroundimage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Login Background image setting.
    $name = 'theme_competency/loginbackgroundimage';
    $title = get_string('loginbackgroundimage', 'theme_boost');
    $description = get_string('loginbackgroundimage_desc', 'theme_boost');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackgroundimage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $settings->add($page);
