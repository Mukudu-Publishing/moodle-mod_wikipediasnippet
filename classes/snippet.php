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
 * Snippet Class - glue with 3rd party lib.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_wikipediasnippet;

/**
 * Snippet class.
 *
 * @package   mod_wikipediasnippet
 * @copyright 2019 - 2021 Mukudu Ltd - Bham UK
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class snippet {

    /** @var int $cachettl caching time to live - probably better elsewhere. */
    public static $cachettl = 24 * 60 * 60;

    /** @var string $lasterror last error. */
    public static $lasterror = null;

    /**
     * Get the wikipeadia snippet.
     *
     * @param string $snippeturl - the snippet URL
     * @param boolean $nolinks - whether to include links.
     * @param boolean $noimages - whether to include images.
     * @param boolean $includecitations - whether to include citations.
     * @param boolean $debug - are we debugging?
     * @return string - HTML snippet.
     */
    public static function get($snippeturl, $nolinks = true, $noimages = false, $includecitations = false, $debug = false) {
        // Load the 3rd party library.
        require_once('wikipediasnippet/wikipediasnippet.inc.php');
        $getter = new \WikipediaSnippet();
        if ($debug) {
            $getter->setdebugging();
        }
        $content = $getter->getWikiContent($snippeturl, $nolinks, $noimages, $includecitations, $debug);

        if ($getter->error) {
            self::$lasterror = $getter->error;
            return null;
        }
        return $content;
    }
}
