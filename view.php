<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * The module form.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

$id = required_param('id', PARAM_INT);
list ($course, $cm) = get_course_and_cm_from_cmid($id, 'wikipediasnippet');
$snippetid = $cm->instance;
$snippetrecord = $DB->get_record('wikipediasnippet', array('id' => $snippetid), '*', MUST_EXIST);

// Protect the page.
require_course_login($course);

// Set up the page for display.
$PAGE->set_context(context_course::instance($course->id));
$PAGE->set_pagelayout('course');
$PAGE->set_heading($snippetrecord->name);
$PAGE->set_title($snippetrecord->name);
$PAGE->set_url(new moodle_url('/mod/$snippetrecord->name/view.php'));

// Get cached item.
$updaterequired = false;
$cache = cache::make('mod_wikipediasnippet', 'wikipediadata');
if ($cached = $cache->get($snippetrecord->id)) {
    if ((time() - $cached['time']) > mod_wikipediasnippet\snippet::$cachettl) {
        $updaterequired = true;
    } else {
        $content = $cached['content'];
    }
} else {
    $updaterequired = true;
}

if ($updaterequired) {
    // Get the content.
    if ($content = mod_wikipediasnippet\snippet::get($snippetrecord->wikiurl, $snippetrecord->nolinks, $snippetrecord->noimages,
            $snippetrecord->includecitations)) {
        // Cache the content.
        $cache->set($snippetrecord->id, array(
            'time' => time(),
            'content' => $content
        ));
    } else {
        if (!empty($cached['content'])) {
            $content = $cached['content'];
        }
    }
}

echo $OUTPUT->header();
echo $OUTPUT->heading($snippetrecord->name);

echo $OUTPUT->box($snippetrecord->intro, "generalbox center clearfix border");

if (!$content) {
    if ($err = mod_wikipediasnippet\snippet::$lasterror) {
        $errmsg = get_string('contentgeterror', 'wikipediasnippet', $err);
        echo $OUTPUT->notification($errmsg, 'error');
    } else {
        echo $OUTPUT->notification( get_string('nowikicontenterror', 'wikipediasnippet'), 'error');
    }
} else {
    echo \html_writer::tag('div', $content);
}

echo $OUTPUT->footer();
