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
 * Theme competency - Library
 *
 * @package     theme_competency
 * @copyright   2022 Debonair Training Ltd, debonairtraining.com
 * @author      Debonair Dev Team
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_competency_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();

    $context = context_system::instance();
    $scss .= file_get_contents($CFG->dirroot . '/theme/competency/scss/competency/pre.scss');
    if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_competency', 'preset', 0, '/', $filename))) {
        $scss .= $presetfile->get_content();
    } else {
        // Safety fallback - maybe new installs etc.
        $scss .= file_get_contents($CFG->dirroot . '/theme/competency/scss/preset/default.scss');
    }
    $scss .= file_get_contents($CFG->dirroot . '/theme/competency/scss/competency.scss');

    if ($theme->settings->sectionstyle == 1) {
        $scss .= file_get_contents($CFG->dirroot . '/theme/competency/scss/sections/sections-competency.scss');
    }

    if ($theme->settings->sectionstyle == 2) {
        $scss .= file_get_contents($CFG->dirroot . '/theme/competency/scss/sections/sections-boxed.scss');
    }

    if ($theme->settings->sectionstyle == 3) {
        $scss .= file_get_contents($CFG->dirroot . '/theme/competency/scss/sections/sections-boost.scss');
    }

    if ($theme->settings->sectionstyle == 4) {
        $scss .= file_get_contents($CFG->dirroot . '/theme/competency/scss/sections/sections-bars.scss');
    }

    $scss .= file_get_contents($CFG->dirroot . '/theme/competency/scss/competency/post.scss');

    return $scss;
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return array
 */
function theme_competency_get_pre_scss($theme) {
    global $CFG;

    $scss = '';
    $configurable = [
        // Config key => [variableName, ...].
            'brandcolor' => ['primary'],
            'successcolor' => ['success'],
            'infocolor' => ['info'],
            'warningcolor' => ['warning'],
            'dangercolor' => ['danger'],
            'secondarycolor' => ['secondary'],
            'iconadministrationcolor' => ['administration'],
            'iconassessmentcolor' => ['assessment'],
            'iconcollaborationcolor' => ['collaboration'],
            'iconcommunicationcolor' => ['communication'],
            'footerbkg' => ['footer-bg'],
            'breadcrumbbkg' => ['breadcrumb-bg'],
            'cardbkg' => ['card-bg'],
            'drawerbkg' => ['drawer-bg'],
            'fploginform' => ['fploginform'],
            'headerimagepadding' => ['headerimagepadding'],
            'markettextbg' => ['markettextbg'],
            'iconcontentcolor' => ['content'],
            'iconinterfacecolor' => ['interface'],
            'courseiconsize' => ['courseiconsize'],
            'navbarbg' => ['navbar-bg'],
            'primarynavbarlink' => ['navbar-dark-color'],
            'secondarynavbarlink' => ['navbar-light-color'],
            'drawerbg' => ['drawer-bg-color'],
            'bodybg' => ['body-bg'],
            'fullwidthpage' => ['fullwidthpage'],
            'showpageimage' => ['showpageimage'],
            'iconwidth' => ['fpicon-width'],
            'slideshowheight' => ['slideshowheight'],
            'activityiconsize' => ['activityiconsize'],
            'gutterwidth' => ['gutterwidth'],
            'topnavbarbg' => ['topnavbarbg'],
            'topnavbarteacherbg' => ['teachernavbarcolor'],
            'slideshowspacer' => ['slideshowspacer'],
    ];

    // Prepend variables first.
    foreach ($configurable as $configkey => $targets) {
        $value = isset($theme->settings->{$configkey}) ? $theme->settings->{$configkey} : null;
        if (empty($value)) {
            continue;
        }
        array_map(function($target) use (&$scss, $value) {
            $scss .= '$' . $target . ': ' . $value . ";\n";
        }, (array) $targets);
    }

    // Prepend pre-scss.
    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }

    // Set the image.
    $marketing1image = $theme->setting_file_url('marketing1image', 'marketing1image');
    if (isset($marketing1image)) {
        // Add a fade in transition to avoid the flicker on course headers ***.
        $scss .= '.marketing1image {background-image: url("' . $marketing1image . '"); background-size:cover; background-position:center;}';
    }

    // Set the image.
    $marketing2image = $theme->setting_file_url('marketing2image', 'marketing2image');
    if (isset($marketing2image)) {
        // Add a fade in transition to avoid the flicker on course headers ***.
        $scss .= '.marketing2image {background-image: url("' . $marketing2image . '"); background-size:cover; background-position:center;}';
    }

    // Set the image.
    $marketing3image = $theme->setting_file_url('marketing3image', 'marketing3image');
    if (isset($marketing3image)) {
        // Add a fade in transition to avoid the flicker on course headers ***.
        $scss .= '.marketing3image {background-image: url("' . $marketing3image . '"); background-size:cover; background-position:center;}';
    }

    return $scss;
}
/**
 * Get compiled css.
 *
 * @return string compiled css
 */
function theme_competency_get_precompiled_css() {
    global $CFG;
    return file_get_contents($CFG->dirroot . '/theme/boost/style/moodle.css');
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_competency_get_extra_scss($theme) {
    $content = '';

    // Sets the login background image.
    $loginbackgroundimageurl = $theme->setting_file_url('loginbackgroundimage', 'loginbackgroundimage');
    if (!empty($loginbackgroundimageurl)) {
        $content .= 'body.pagelayout-login #page { ';
        $content .= "background-image: url('$loginbackgroundimageurl'); background-size: cover;";
        $content .= ' }';
    }

    return $content;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_competency_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    static $theme;
    if (empty($theme)) {
        $theme = theme_config::load('competency');
    }
    if ($context->contextlevel == CONTEXT_SYSTEM && ($filearea === '')) {
        $theme = theme_config::load('competency');
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else if ($filearea === 'headerlogo') {
        return $theme->setting_file_serve('headerlogo', $args, $forcedownload, $options);
    } else if ($filearea === 'favicon') {
        return $theme->setting_file_serve('favicon', $args, $forcedownload, $options);
    } else if ($filearea === 'feature1image') {
        return $theme->setting_file_serve('feature1image', $args, $forcedownload, $options);
    } else if ($filearea === 'feature2image') {
        return $theme->setting_file_serve('feature2image', $args, $forcedownload, $options);
    } else if ($filearea === 'feature3image') {
        return $theme->setting_file_serve('feature3image', $args, $forcedownload, $options);
    } else if ($filearea === 'headerdefaultimage') {
        return $theme->setting_file_serve('headerdefaultimage', $args, $forcedownload, $options);
    } else if ($filearea === 'backgroundimage') {
        return $theme->setting_file_serve('backgroundimage', $args, $forcedownload, $options);
    } else if ($filearea === 'loginimage') {
        return $theme->setting_file_serve('loginimage', $args, $forcedownload, $options);
    } else if ($filearea === 'logintopimage') {
        return $theme->setting_file_serve('logintopimage', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing1image') {
        return $theme->setting_file_serve('marketing1image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing2image') {
        return $theme->setting_file_serve('marketing2image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing3image') {
        return $theme->setting_file_serve('marketing3image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing4image') {
        return $theme->setting_file_serve('marketing4image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing5image') {
        return $theme->setting_file_serve('marketing5image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing6image') {
        return $theme->setting_file_serve('marketing6image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing7image') {
        return $theme->setting_file_serve('marketing7image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing8image') {
        return $theme->setting_file_serve('marketing8image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing9image') {
        return $theme->setting_file_serve('marketing9image', $args, $forcedownload, $options);
    } else if ($filearea === 'category1image') {
        return $theme->setting_file_serve('category1image', $args, $forcedownload, $options);
    } else if ($filearea === 'category2image') {
        return $theme->setting_file_serve('category2image', $args, $forcedownload, $options);
    } else if ($filearea === 'category3image') {
        return $theme->setting_file_serve('category3image', $args, $forcedownload, $options);
    } else if ($filearea === 'category4image') {
        return $theme->setting_file_serve('category4image', $args, $forcedownload, $options);
    } else if ($filearea === 'slide1image') {
        return $theme->setting_file_serve('slide1image', $args, $forcedownload, $options);
    } else if ($filearea === 'slide2image') {
        return $theme->setting_file_serve('slide2image', $args, $forcedownload, $options);
    } else if ($filearea === 'slide3image') {
        return $theme->setting_file_serve('slide3image', $args, $forcedownload, $options);
    }else if ($filearea === 'pagebackgroundimage') {
        return $theme->setting_file_serve('pagebackgroundimage', $args, $forcedownload, $options);
    }else if ($filearea === 'loginbackgroundimage') {
        return $theme->setting_file_serve('loginbackgroundimage', $args, $forcedownload, $options);
    }else if ($filearea === 'headerimage') {
        return $theme->setting_file_serve('headerimage', $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}

/**
 * Logo Image URL Fetch from theme settings
 *
 * @param string $type
 * @return image $logo
 */
function theme_competency_get_logo_url($type='header') {
    global $OUTPUT;
    static $theme;
    if (empty($theme)) {
        $theme = theme_config::load('competency');
    }

    if ($type == "header") {
        $logo = $theme->setting_file_url('headerimage', 'headerimage');
        $logo = empty($logo) ? $OUTPUT->image_url('home/headerimage', 'theme') : $logo;
    }else{
      $logo = $theme->setting_file_url('headerimage', 'headerimage');
      $logo = empty($logo) ? $OUTPUT->image_url('home/headerimage', 'theme') : $logo;
    }
    return $logo;
}
