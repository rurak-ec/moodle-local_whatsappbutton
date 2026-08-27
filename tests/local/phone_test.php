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

namespace local_whatsappbutton\local;

/**
 * Tests for WhatsApp phone-number handling.
 *
 * @package    local_whatsappbutton
 * @copyright  2026 Rurak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \local_whatsappbutton\local\phone
 */
final class phone_test extends \basic_testcase {
    /**
     * Separators and a leading plus sign are removed.
     */
    public function test_normalise_removes_non_digits(): void {
        $this->assertSame('593991234567', phone::normalise('+593 99-123-4567'));
    }

    /**
     * Valid international numbers follow the E.164 length constraints.
     *
     * @dataProvider validity_provider
     * @param string $number Number to validate.
     * @param bool $expected Expected validation result.
     */
    public function test_validation(string $number, bool $expected): void {
        $this->assertSame($expected, phone::is_valid($number));
    }

    /**
     * Provide valid and invalid numbers.
     *
     * @return array<string, array{string, bool}>
     */
    public static function validity_provider(): array {
        return [
            'minimum valid length' => ['12345678', true],
            'maximum valid length' => ['123456789012345', true],
            'too short' => ['1234567', false],
            'too long' => ['1234567890123456', false],
            'leading zero' => ['02345678', false],
            'contains separators' => ['+593 99 123 4567', false],
        ];
    }
}
