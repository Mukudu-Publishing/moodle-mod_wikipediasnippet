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
 * Backup steps file.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Define the complete structure for backup,
 *
 * with file and id annotations
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_wikipediasnippet_activity_structure_step extends backup_activity_structure_step {

    /**
     * Define the structure to be processed by this backup step.
     *
     * @return backup_nested_element
     */
    protected function define_structure() {

        // Are we including user information?
        // If we are - uncomment below ...
        // ... $userinfo = $this->get_setting_value('userinfo');.

        // Define each element separated.
        $snippet = new backup_nested_element('wikipediasnippet', array('id'), array('name', 'intro', 'introformat', 'wikiurl',
                    'noimages', 'nolinks', 'includecitations', 'timecreated', 'timemodified'));

        // Build the tree - no connected tables.

        // Define the data sources.
        $snippet->set_source_table('wikipediasnippet', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations - None.

        // Define file annotations - No files.

        // Return the root element, wrapped into standard activity structure.
        return $this->prepare_activity_structure($snippet);
    }
}