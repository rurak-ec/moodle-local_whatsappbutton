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
 * Phone-number helpers.
 *
 * @package    local_whatsappbutton
 * @copyright  2026 Rurak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_whatsappbutton\local;

/**
 * Normalises and validates WhatsApp-compatible international numbers.
 */
final class phone {
    /**
     * Remove separators, spaces and the optional leading plus sign.
     *
     * @param string $number Number supplied by the administrator.
     * @return string Digits only.
     */
    public static function normalise(string $number): string {
        return preg_replace('/\\D+/', '', $number) ?? '';
    }

    /**
     * Check the E.164 length and the non-zero country-code prefix.
     *
     * @param string $number Digits-only number.
     * @return bool Whether it can safely be used in a wa.me URL.
     */
    public static function is_valid(string $number): bool {
        return preg_match('/^[1-9][0-9]{7,14}$/', $number) === 1;
    }
}
