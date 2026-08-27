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
 * Validated setting for a WhatsApp number.
 *
 * @package    local_whatsappbutton
 * @copyright  2026 Rurak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_whatsappbutton\admin_setting;

use local_whatsappbutton\local\phone;

/**
 * Stores the number as international digits only.
 */
class whatsapp_number extends \admin_setting_configtext {
    /**
     * Validate and normalise the submitted value before it is saved.
     *
     * @param string $data Value entered by the administrator.
     * @return string Empty on success, otherwise an error message.
     */
    public function write_setting($data) {
        $number = phone::normalise((string)$data);

        // An empty value is valid during a fresh installation. The renderer keeps
        // the widget hidden until an administrator configures a valid number.
        if ($number === '') {
            return parent::write_setting('');
        }

        if (!phone::is_valid($number)) {
            return get_string('invalidnumber', 'local_whatsappbutton');
        }

        return parent::write_setting($number);
    }
}
