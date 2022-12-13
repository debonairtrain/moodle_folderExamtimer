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
 * Strings for component 'folderexamtimer', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package   mod_folderexamtimer
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['bynameondate'] = 'by {$a->name} - {$a->date}';
$string['contentheader'] = 'Content';

$string['pluginname'] = 'Folder Exam Timer';
$string['folderexamtimer_title'] = 'Folder Examtimer title';
$string['completiondownload'] = 'Student Must download the file';
$string['dnduploadmakefolderexamtimer'] = 'Unzip files and create folderexamtimer';
$string['downloadfolderexamtimer'] = 'Download Files';
$string['duedate'] = 'Exam Start Date & Time';
$string['duedate_help'] = 'This is when the assignment is due. Submissions will still be allowed after this date, but any assignments submitted after this date will be marked as late. Set an assignment cut-off date to prevent submissions after a certain date.';
$string['duedatecolon'] = 'Due date: {$a}';
$string['eventallfilesdownloaded'] = 'Zip archive of folderexamtimer downloaded';
$string['eventfolderexamtimerupdated'] = 'folderexamtimer updated';
$string['folderexamtimer:addinstance'] = 'Add a new folderexamtimer';
$string['folderexamtimer:managefiles'] = 'Manage files in folderexamtimer module';
$string['folderexamtimer:view'] = 'View folderexamtimer content';
$string['days'] = 'Days';
$string['hours'] = 'Hours';
$string['minutes'] = 'Minutes';
$string['seconds'] = 'Seconds';
$string['folderexamtimercontent'] = 'Files and subfolderexamtimers';
$string['forcedownload'] = 'Force download of files';
$string['completiondownloaddesc'] = 'Done Download';
$string['forcedownload_help'] = 'Whether certain files, such as images or HTML files, should be displayed in the browser rather than being downloaded. Note that for security reasons, the setting should only be unticked if all users with the capability to manage files in the folderexamtimer are trusted users.';
$string['indicator:cognitivedepth'] = 'folderexamtimer cognitive';
$string['indicator:cognitivedepth_help'] = 'This indicator is based on the cognitive depth reached by the student in a folderexamtimer resource.';
$string['indicator:cognitivedepthdef'] = 'folderexamtimer cognitive';
$string['indicator:cognitivedepthdef_help'] = 'The participant has reached this percentage of the cognitive engagement offered by the folderexamtimer resources during this analysis interval (Levels = No view, View)';
$string['indicator:cognitivedepthdef_link'] = 'Learning_analytics_indicators#Cognitive_depth';
$string['indicator:socialbreadth'] = 'folderexamtimer social';
$string['indicator:socialbreadth_help'] = 'This indicator is based on the social breadth reached by the student in a folderexamtimer resource.';
$string['indicator:socialbreadthdef'] = 'folderexamtimer social';
$string['indicator:socialbreadthdef_help'] = 'The participant has reached this percentage of the social engagement offered by the folderexamtimer resources during this analysis interval (Levels = No participation, Participant alone)';
$string['indicator:socialbreadthdef_link'] = 'Learning_analytics_indicators#Social_breadth';
$string['modulename'] = 'Folder Examtimer';
$string['modulename_help'] = 'The folderexamtimer module enables a teacher to display a number of related files inside a single folderexamtimer, reducing scrolling on the course page. A zipped folderexamtimer may be uploaded and unzipped for display, or an empty folderexamtimer created and files uploaded into it.

A folderexamtimer may be used

* For a series of files on one topic, for example a set of past examination papers in pdf format or a collection of image files for use in student projects
* To provide a shared uploading space for teachers on the course page (keeping the folderexamtimer hidden so that only teachers can see it)';
$string['modulename_link'] = 'mod/folderexamtimer/view';
$string['modulenameplural'] = 'folderexamtimers';
$string['newfolderexamtimercontent'] = 'New folderexamtimer content';
$string['page-mod-folderexamtimer-x'] = 'Any folderexamtimer module page';
$string['page-mod-folderexamtimer-view'] = 'folderexamtimer module main page';
$string['privacy:metadata'] = 'The folderexamtimer resource plugin does not store any personal data.';
$string['pluginadministration'] = 'folderexamtimer administration';
$string['display'] = 'Display folderexamtimer contents';
$string['display_help'] = 'If you choose to display the folderexamtimer contents on a course page, there will be no link to a separate page. The description will be displayed only if \'Display description on course page\' is ticked. Note that participants view actions cannot be logged in this case.';
$string['displaypage'] = 'On a separate page';
$string['displayinline'] = 'Inline on a course page';
$string['noautocompletioninline'] = 'Automatic completion on viewing of activity can not be selected together with "Display inline" option';
$string['search:activity'] = 'Folder Examtimer';
$string['showdownloadfolderexamtimer'] = 'Show download folderexamtimer button';
$string['showdownloadfolderexamtimer_help'] = 'If set to \'yes\', a button will be displayed allowing the contents of the folderexamtimer to be downloaded as a zip file.';
$string['showexpanded'] = 'Show subfolderexamtimers expanded';
$string['showexpanded_help'] = 'If set to \'yes\', subfolderexamtimers are shown expanded by default; otherwise they are shown collapsed.';
$string['maxsizetodownload'] = 'Maximum folderexamtimer download size (MB)';
$string['maxsizetodownload_help'] = 'The maximum size of folderexamtimer that can be downloaded as a zip file. If set to zero, the folderexamtimer size is unlimited.';
