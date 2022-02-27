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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/moodleform_mod.php');

/**
 * The module form.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_wikipediasnippet_mod_form extends moodleform_mod {
    
    /**
     * Defines forms elements
     */
    public function definition() {
        
        $mform = $this->_form;
        
        // Adding the "general" fieldset, where all the common settings are showed.
        $mform->addElement('header', 'general', get_string('general', 'form'));
        
        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('wikipediasnippetname', 'wikipediasnippet'), array('size' => '64'));
        $mform->setType('name', PARAM_CLEAN);
        
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'wikipediasnippetname', 'wikipediasnippet');
        
        // The standard "intro" & "introformat" flds.
        $this->standard_intro_elements();
        
        // Adding the rest of wikipediasnippet settings.
        $mform->addElement('header', 'specific', get_string('ws_formsection', 'wikipediasnippet'));
        
        // Wikipedia URL.
        $mform->addElement('text', 'wikiurl', get_string('wikis_url', 'wikipediasnippet'), array('size' => '80'));
        if (!empty( $this->_customdata['wikiurl'])) {
            
            $mform->setDefault('wikiurl', $this->_customdata['wikiurl']);
        }
        $mform->setType('wikiurl', PARAM_URL);
        $mform->addRule('wikiurl', null, 'required', null, 'client');
        $mform->addElement('static', 'label1', '', get_string('wikis_url_help', 'wikipediasnippet'));
        
        // Include images?
        $mform->addElement('checkbox', 'noimages', get_string('wikis_excludeImages', 'wikipediasnippet'));
        if (!empty( $this->_customdata['noimages'])) {
            $mform->setDefault('noimages', $this->_customdata['noimages']);
        }
        $mform->setType('noimages', PARAM_INT);
        $mform->addElement('static', 'label2', '', get_string('wikis_excludeImages_help', 'wikipediasnippet'));
        
        // Include links?
        $mform->addElement('checkbox', 'nolinks', get_string('wikis_excludeLinks', 'wikipediasnippet'));
        if (!empty( $this->_customdata['nolinks'])) {
            $mform->setDefault('nolinks', $this->_customdata['nolinks']);
        }
        $mform->setType('nolinks', PARAM_INT);
        $mform->addElement('static', 'label3', '', get_string('wikis_excludeLinks_help', 'wikipediasnippet'));
        
        // Include citations?
        $mform->addElement('checkbox', 'includecitations', get_string('wikis_includecitations', 'wikipediasnippet'));
        if (!empty($this->_customdata['includecitations'])) {
            $mform->setDefault('includecitations', $this->_customdata['includecitations']);
        }
        $mform->setType('includecitations', PARAM_INT);
        $mform->addElement('static', 'label4', '', get_string('wikis_includecitations_help', 'wikipediasnippet'));
        
        // Add standard elements, common to all modules.
        $this->standard_coursemodule_elements();
        
        // Add standard buttons, common to all modules.
        $this->add_action_buttons();
    }
}
