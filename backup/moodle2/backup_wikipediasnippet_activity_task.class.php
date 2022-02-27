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
 * Backup steps.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once('backup_wikipediasnippet_stepslib.php');

/**
 * backup task that provides all the settings and
 *
 * steps to perform one complete backup of the activity.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_wikipediasnippet_activity_task extends backup_activity_task {
    
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
        $step = new backup_wikipediasnippet_activity_structure_step('wikipediasnippet_structure', 'wikipediasnippet.xml');
        $this->add_step($step);
    }
    
    /**
     * Code transformations to perform in the activity
     *
     * in order to get transportable (encoded) links
     * @param string $content
     * @return string
     */
    static public function encode_content_links($content) {
        return $content;
    }
}
