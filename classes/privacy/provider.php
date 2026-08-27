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
 * Privacy provider for the WhatsApp button.
 *
 * @package    local_whatsappbutton
 * @copyright  2026 Rurak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_whatsappbutton\privacy;

use core_privacy\local\metadata\collection;

/**
 * Describes the optional data sent to WhatsApp at the visitor's request.
 */
class provider implements \core_privacy\local\metadata\provider {
    /**
     * Describe the external WhatsApp location.
     *
     * @param collection $collection Privacy metadata collection.
     * @return collection Updated metadata collection.
     */
    public static function get_metadata(collection $collection): collection {
        $collection->add_external_location_link(
            'whatsapp.com',
            ['message' => 'privacy:metadata:whatsapp:message'],
            'privacy:metadata:whatsapp'
        );

        return $collection;
    }
}
