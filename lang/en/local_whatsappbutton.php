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
 * English strings for the WhatsApp button.
 *
 * @package    local_whatsappbutton
 * @copyright  2026 Rurak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'WhatsApp button';
$string['settingsheading'] = 'Floating WhatsApp button';
$string['settingsdescription'] = 'Set the destination number and choose where the fixed button is shown. The link is generated automatically.';
$string['enabled'] = 'Enable WhatsApp button';
$string['enabled_desc'] = 'When disabled, the button is not shown anywhere.';
$string['number'] = 'WhatsApp number';
$string['number_desc'] = 'International number with country code. Spaces, hyphens and a leading + are accepted and removed automatically. Example: +593 99 123 4567. Generated link: https://wa.me/&lt;number&gt;';
$string['numberrequired'] = 'Enter a WhatsApp number before saving.';
$string['invalidnumber'] = 'Enter a valid international WhatsApp number: 8 to 15 digits, beginning with the country code.';
$string['enablechat'] = 'Enable chat window';
$string['enablechat_desc'] = 'When enabled, the button opens the message window and can show the red notification dot. When disabled, the button opens WhatsApp directly. Disabled by default.';
$string['directmessage'] = 'Default direct message';
$string['directmessage_desc'] = 'Optional message included in the WhatsApp link when the chat window is disabled. Leave empty to open the configured number without a message.';
$string['appearanceheading'] = 'Chat appearance';
$string['appearancedescription'] = 'Configure the identity and welcome message shown in the chat window.';
$string['colormode'] = 'Colour mode';
$string['colormode_desc'] = 'Choose the widget colour mode manually. Light is used by default.';
$string['colormode_dark'] = 'Dark';
$string['colormode_light'] = 'Light';
$string['businessname'] = 'Display name';
$string['businessname_desc'] = 'Name shown beside the profile image in the chat header.';
$string['avatar'] = 'Profile image';
$string['avatar_desc'] = 'Optional PNG, JPG or WebP image, up to 2 MB. When empty, a person icon is used.';
$string['greeting'] = 'Welcome message';
$string['greeting_desc'] = 'Initial message shown inside the incoming chat bubble. Line breaks and emoji are supported.';
$string['defaultgreeting'] = "Hello! 👋\nTell us which process you want to automate.";
$string['visibilityheading'] = 'Visibility';
$string['visibilitydescription'] = 'Administrative, login and technical pages are always excluded.';
$string['showfrontpage'] = 'Site home page';
$string['showfrontpage_desc'] = 'Show the button on the site home page.';
$string['showdashboard'] = 'Dashboard';
$string['showdashboard_desc'] = 'Show the button in the user dashboard.';
$string['showcourses'] = 'Courses and activities';
$string['showcourses_desc'] = 'Show the button on course pages, activities and pages belonging to a course.';
$string['showother'] = 'Other public Moodle pages';
$string['showother_desc'] = 'Show the button on ordinary pages outside the areas selected above.';
$string['openwhatsapp'] = 'Open WhatsApp support';
$string['closechat'] = 'Close WhatsApp chat';
$string['sendmessage'] = 'Send message to WhatsApp';
$string['messageinputlabel'] = 'Message for WhatsApp';
$string['messageplaceholder'] = 'Write your message...';
$string['privacy:metadata:whatsapp'] = 'When a visitor chooses to open or send a message, the WhatsApp button redirects their browser to WhatsApp. Moodle does not store the message.';
$string['privacy:metadata:whatsapp:message'] = 'The message entered by the visitor or configured by the administrator is included in the WhatsApp URL.';
