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
 * Backup restore steps file.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Backup restore steps file.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_wikipediasnippet_activity_structure_step extends restore_activity_structure_step {

    /**
     * Declares paths in the grading.xml file we are interested in
     *
     */
    protected function define_structure() {

        $paths = array();
        $paths[] = new restore_path_element('wikipediasnippet', '/activity/wikipediasnippet');

        // Return the paths wrapped into standard activity structure.
        return $this->prepare_activity_structure($paths);
    }


    /**
     * Save the data.
     *
     * @param stdClass $data
     */
    protected function process_wikipediasnippet($data) {
        global $DB;

        $data = (object) $data;
        // Get the new course id.
        $data->course = $this->get_courseid();

        // If you need to set dates offset start/end dates call ...
        // ... $data->timeopen = $this->apply_date_offset($data->timeopen);.

        // We want to determine new times - we could have not backed up the fields.
        $data->timecreated = time();
        $data->timemodified = time();

        // Insert the record.
        $newitemid = $DB->insert_record('wikipediasnippet', $data);
        // Immediately after inserting record, call this.
        $this->apply_activity_instance($newitemid);
    }
}