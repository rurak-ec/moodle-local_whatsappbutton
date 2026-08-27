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
 * Global settings for the WhatsApp button.
 *
 * @package    local_whatsappbutton
 * @copyright  2026 Rurak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage(
        'local_whatsappbutton_settings',
        get_string('pluginname', 'local_whatsappbutton')
    );

    if ($ADMIN->fulltree) {
        $settings->add(new admin_setting_heading(
            'local_whatsappbutton_information',
            get_string('settingsheading', 'local_whatsappbutton'),
            get_string('settingsdescription', 'local_whatsappbutton')
        ));

        $settings->add(new admin_setting_configcheckbox(
            'local_whatsappbutton/enabled',
            get_string('enabled', 'local_whatsappbutton'),
            get_string('enabled_desc', 'local_whatsappbutton'),
            1
        ));

        $settings->add(new \local_whatsappbutton\admin_setting\whatsapp_number(
            'local_whatsappbutton/number',
            get_string('number', 'local_whatsappbutton'),
            get_string('number_desc', 'local_whatsappbutton'),
            ''
        ));

        $settings->add(new admin_setting_configcheckbox(
            'local_whatsappbutton/enablechat',
            get_string('enablechat', 'local_whatsappbutton'),
            get_string('enablechat_desc', 'local_whatsappbutton'),
            0
        ));

        $settings->add(new admin_setting_configtextarea(
            'local_whatsappbutton/directmessage',
            get_string('directmessage', 'local_whatsappbutton'),
            get_string('directmessage_desc', 'local_whatsappbutton'),
            '',
            PARAM_TEXT
        ));

        $settings->add(new admin_setting_heading(
            'local_whatsappbutton_appearanceheading',
            get_string('appearanceheading', 'local_whatsappbutton'),
            get_string('appearancedescription', 'local_whatsappbutton')
        ));

        $settings->add(new admin_setting_configselect(
            'local_whatsappbutton/colormode',
            get_string('colormode', 'local_whatsappbutton'),
            get_string('colormode_desc', 'local_whatsappbutton'),
            'light',
            [
                'light' => get_string('colormode_light', 'local_whatsappbutton'),
                'dark' => get_string('colormode_dark', 'local_whatsappbutton'),
            ]
        ));

        $settings->add(new admin_setting_configtext(
            'local_whatsappbutton/businessname',
            get_string('businessname', 'local_whatsappbutton'),
            get_string('businessname_desc', 'local_whatsappbutton'),
            'Rurak',
            PARAM_TEXT
        ));

        $settings->add(new admin_setting_configstoredfile(
            'local_whatsappbutton/avatar',
            get_string('avatar', 'local_whatsappbutton'),
            get_string('avatar_desc', 'local_whatsappbutton'),
            'avatar',
            0,
            [
                'maxfiles' => 1,
                'maxbytes' => 2 * 1024 * 1024,
                'subdirs' => 0,
                'accepted_types' => ['.png', '.jpg', '.jpeg', '.webp'],
            ]
        ));

        $settings->add(new admin_setting_configtextarea(
            'local_whatsappbutton/greeting',
            get_string('greeting', 'local_whatsappbutton'),
            get_string('greeting_desc', 'local_whatsappbutton'),
            get_string('defaultgreeting', 'local_whatsappbutton'),
            PARAM_TEXT
        ));

        $settings->add(new admin_setting_heading(
            'local_whatsappbutton_visibilityheading',
            get_string('visibilityheading', 'local_whatsappbutton'),
            get_string('visibilitydescription', 'local_whatsappbutton')
        ));

        $settings->add(new admin_setting_configcheckbox(
            'local_whatsappbutton/showfrontpage',
            get_string('showfrontpage', 'local_whatsappbutton'),
            get_string('showfrontpage_desc', 'local_whatsappbutton'),
            1
        ));

        $settings->add(new admin_setting_configcheckbox(
            'local_whatsappbutton/showdashboard',
            get_string('showdashboard', 'local_whatsappbutton'),
            get_string('showdashboard_desc', 'local_whatsappbutton'),
            1
        ));

        $settings->add(new admin_setting_configcheckbox(
            'local_whatsappbutton/showcourses',
            get_string('showcourses', 'local_whatsappbutton'),
            get_string('showcourses_desc', 'local_whatsappbutton'),
            1
        ));

        $settings->add(new admin_setting_configcheckbox(
            'local_whatsappbutton/showother',
            get_string('showother', 'local_whatsappbutton'),
            get_string('showother_desc', 'local_whatsappbutton'),
            0
        ));
    }

    $ADMIN->add('localplugins', $settings);
}
