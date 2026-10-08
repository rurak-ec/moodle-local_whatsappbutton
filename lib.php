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
 * Library functions for the WhatsApp button.
 *
 * @package    local_whatsappbutton
 * @copyright  2026 Rurak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Serve the administrator-configured avatar.
 *
 * The widget can be visible to guests, so this system-level branding image is
 * intentionally public. Only the single avatar file area is exposed.
 *
 * @param stdClass|null $course Course record, unused for a system file.
 * @param stdClass|null $cm Course-module record, unused for a system file.
 * @param context $context File context.
 * @param string $filearea Requested file area.
 * @param array $args Remaining path components.
 * @param bool $forcedownload Whether Moodle requested a forced download.
 * @param array $options File-serving options.
 * @return bool False when the requested file does not exist or is not allowed.
 */
function local_whatsappbutton_pluginfile(
    $course,
    $cm,
    context $context,
    string $filearea,
    array $args,
    bool $forcedownload,
    array $options = []
): bool {
    if ($context->contextlevel !== CONTEXT_SYSTEM || $filearea !== 'avatar' || empty($args)) {
        return false;
    }

    // Moodle passes the item id as the first path component (make_pluginfile_url adds "/0/"); the avatar always uses 0.
    if (count($args) > 1 && ctype_digit((string)$args[0])) {
        if ((int)array_shift($args) !== 0) {
            return false;
        }
    }

    $filename = array_pop($args);
    $filepath = '/' . ($args ? implode('/', $args) . '/' : '');
    $file = get_file_storage()->get_file(
        $context->id,
        'local_whatsappbutton',
        'avatar',
        0,
        $filepath,
        $filename
    );

    if (!$file || $file->is_directory()) {
        return false;
    }

    $options['cacheability'] = 'public';
    send_stored_file($file, YEARSECS, 0, false, $options);
}
