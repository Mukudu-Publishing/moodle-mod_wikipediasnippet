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
 * Backup restore task file.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once('restore_wikipediasnippet_stepslib.php');

/**
 * Backup restore task file.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_wikipediasnippet_activity_task extends restore_activity_task {
    
    /**
     * Define (add) settings for this activity.
     *
     */
    protected function define_my_settings() {
        // No particular settings for this activity.
    }
    
    /**
     * Define (add) steps this activity can have.
     *
     */
    protected function define_my_steps() {
        // Call our steps definition.
        $step = new restore_wikipediasnippet_activity_structure_step('wikipediasnippet_structure', 'wikipediasnippet.xml');
        $this->add_step($step);
    }
    
    /**
     * Define the contents in the activity that must be
     *
     * processed by the link decoder
     */
    static public function define_decode_contents() {
        return array();
    }
    
    /**
     * Define the decoding rules for links belonging
     *
     * to activity to be executed by the link decoder
     */
    static public function define_decode_rules() {
        return array();
    }
}
