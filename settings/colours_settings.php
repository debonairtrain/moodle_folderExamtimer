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
 * Colours settings page file.
 *
 * @package     theme_competency
 * @copyright   2022 Debonair Training Ltd, debonairtraining.com
 * @author      Debonair Dev Team
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

$page = new admin_settingpage('theme_competency_colours', get_string('colours_settings', 'theme_competency'));
$page->add(new admin_setting_heading('theme_competency_colours', get_string('colours_headingsub', 'theme_competency'), format_text(get_string('colours_desc' , 'theme_competency'), FORMAT_MARKDOWN)));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_configtextarea('theme_competency/scsspre',
    get_string('rawscsspre', 'theme_competency'), get_string('rawscsspre_desc', 'theme_competency'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    // Variable $body-color.
    // We use an empty default value because the default colour should come from the preset .
    $name = 'theme_competency/navbarbg';
    $title = get_string('navbarbg', 'theme_competency');
    $description = get_string('navbarbg_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/primarynavbarlink';
    $title = get_string('primarynavbarlink', 'theme_competency');
    $description = get_string('navbarlink_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/secondarynavbarlink';
    $title = get_string('secondarynavbarlink', 'theme_competency');
    $description = get_string('navbarlink_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/drawerbg';
    $title = get_string('drawerbg', 'theme_competency');
    $description = get_string('drawerbg_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/bodybg';
    $title = get_string('bodybg', 'theme_competency');
    $description = get_string('bodybg_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


    $name = 'theme_competency/brandcolor';
    $title = get_string('brandcolor', 'theme_boost');
    $description = get_string('brandcolor_desc', 'theme_boost');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/successcolor';
    $title = get_string('successcolor', 'theme_competency');
    $description = get_string('rootcolor_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/infocolor';
    $title = get_string('infocolor', 'theme_competency');
    $description = get_string('rootcolor_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/warningcolor';
    $title = get_string('warningcolor', 'theme_competency');
    $description = get_string('rootcolor_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/dangercolor';
    $title = get_string('dangercolor', 'theme_competency');
    $description = get_string('rootcolor_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/secondarycolor';
    $title = get_string('secondarycolor', 'theme_competency');
    $description = get_string('rootcolor_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/iconadministrationcolor';
    $title = get_string('iconadministrationcolor', 'theme_competency');
    $description = get_string('iconrootcolor_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/iconassessmentcolor';
    $title = get_string('iconassessmentcolor', 'theme_competency');
    $description = get_string('iconrootcolor_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/iconcollaborationcolor';
    $title = get_string('iconcollaborationcolor', 'theme_competency');
    $description = get_string('iconrootcolor_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/iconcommunicationcolor';
    $title = get_string('iconcommunicationcolor', 'theme_competency');
    $description = get_string('iconrootcolor_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/iconcontentcolor';
    $title = get_string('iconcontentcolor', 'theme_competency');
    $description = get_string('iconrootcolor_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_competency/iconinterfacecolor';
    $title = get_string('iconinterfacecolor', 'theme_competency');
    $description = get_string('iconrootcolor_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer drawer background
    $name = 'theme_competency/footerbkg';
    $title = get_string('footerbkg', 'theme_competency');
    $description = get_string('footerbkg_desc', 'theme_competency');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_competency/scss', get_string('rawscss', 'theme_boost'),
            get_string('rawscss_desc', 'theme_boost'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

// Must add the page after definiting all the settings!
$settings->add($page);
