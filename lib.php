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
 * Our lib file.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Moodle Features supported.
 * @param int $feature - the feature beinf checked for.
 * @return boolean|int|NULL
 */
function wikipediasnippet_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_MOD_ARCHETYPE:
            return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        default:
            return null;
    }
}

/**
 *  Delete a module instance.
 *
 * @param int $id
 * @return boolean
 */
function wikipediasnippet_delete_instance($id) {
    global $DB;

    $cache = cache::make('mod_wikipediasnippet', 'wikipediadata');
    if ($cache->get($id)) {
        $cache->delete($id);
    }

    return $DB->delete_records('wikipediasnippet', array('id' => $id));
}

/**
 * Add a new module instance.
 *
 * @param stdClass $wikipediasnippet - submitted form data.
 * @param moodleform $mform
 * @return int - new record id.
 */
function wikipediasnippet_add_instance($wikipediasnippet, $mform) {
    global $DB;

    $thistime = time();
    $wikipediasnippet->timecreated = $thistime;
    $wikipediasnippet->timemodified = $thistime;

    if (empty($wikipediasnippet->nolinks)) {
        $wikipediasnippet->nolinks = 0;
    }
    if (empty($wikipediasnippet->noimages)) {
        $wikipediasnippet->noimages = 0;
    }

    // Get the content.
    if ($snippet = mod_wikipediasnippet\snippet::get($wikipediasnippet->wikiurl, $wikipediasnippet->nolinks,
            $wikipediasnippet->noimages)) {

        $id = $DB->insert_record('wikipediasnippet', $wikipediasnippet);

        // Cache the content.
        $cache = cache::make('mod_wikipediasnippet', 'wikipediadata');
        $cache->set($id, array('time' => $thistime, 'content' => $snippet));
        return $id;
    } else {
        $error = mod_wikipediasnippet\snippet::$lasterror;
        if ($error) {
            print_error('contentgeterror', 'wikipediasnippet', null, $error);
        } else {
            print_error('nowikicontenterror', 'wikipediasnippet');
        }
    }
}

/**
 * Update an existing module instance.
 *
 * @param int $wsnip - module id.
 * @param moodleform $mform - the moodle form object.
 * @return boolean
 */
function wikipediasnippet_update_instance($wsnip, $mform) {
    global $DB;

    $wsnip->timemodified = time();

    $wsnip->id = $wsnip->instance;

    if (empty($wsnip->nolinks)) {
        $wsnip->nolinks = 0;
    }
    if (empty($wsnip->noimages)) {
        $wsnip->noimages = 0;
    }
    if (empty($wsnip->includecitations)) {
        $wsnip->includecitations = 0;
    }

    if ($record = $DB->get_record('wikipediasnippet', array('id' => $wsnip->id))) {
        $updated = false;
        if ($wsnip->wikiurl == $record->wikiurl) {
            if ($wsnip->nolinks == $record->nolinks) {
                if ($wsnip->noimages == $record->noimages) {
                    if ($wsnip->includecitations != $record->includecitations) {
                        $updated = true;
                    }
                } else {
                    $updated = true;
                }
            } else {
                $updated = true;
            }
        } else {
            $updated = true;
        }

        $cache = cache::make('mod_wikipediasnippet', 'wikipediadata');
        // Check if the cache is stale.
        if (!$updated) {
            $wid = $wsnip->id;
            if ($cached = $cache->get($wid)) {
                $ttl = mod_wikipediasnippet\snippet::$cachettl;
                if ((time() - $cached['time']) > $ttl) {
                    $updated = true;
                }
            } else {
                $updated = true;
            }
        }

        if ($updated) {
            // Get the content.
            if ($snippet = mod_wikipediasnippet\snippet::get($wsnip->wikiurl, $wsnip->nolinks, $wsnip->noimages,
                        $wsnip->includecitations)) {
                // Cache the content.
                $cache->set($wsnip->id, array( 'time' => time(), 'content' => $snippet));
            }
        }
    } else {
        return false;
    }

    return $DB->update_record('wikipediasnippet', $wsnip);
}