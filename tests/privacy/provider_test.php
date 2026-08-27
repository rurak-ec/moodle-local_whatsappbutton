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

namespace local_whatsappbutton\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\metadata\types\external_location;

/**
 * Tests for the privacy metadata provider.
 *
 * @package    local_whatsappbutton
 * @copyright  2026 Rurak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \local_whatsappbutton\privacy\provider
 */
final class provider_test extends \core_privacy\tests\provider_testcase {
    /**
     * WhatsApp is declared as the single external data destination.
     */
    public function test_get_metadata_declares_whatsapp(): void {
        $collection = provider::get_metadata(new collection('local_whatsappbutton'));
        $items = $collection->get_collection();

        $this->assertCount(1, $items);
        $this->assertInstanceOf(external_location::class, $items[0]);
        $this->assertSame('whatsapp.com', $items[0]->get_name());
    }
}
