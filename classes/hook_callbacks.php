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
 * Output hook callbacks for the WhatsApp button.
 *
 * @package    local_whatsappbutton
 * @copyright  2026 Rurak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_whatsappbutton;

use local_whatsappbutton\local\phone;

/**
 * Adds the button only to configured, ordinary Moodle pages.
 */
class hook_callbacks {
    /**
     * Register the button's CSS while <head> is still being generated.
     *
     * @param \core\hook\output\before_standard_head_html_generation $hook Output hook.
     */
    public static function add_head_assets(
        \core\hook\output\before_standard_head_html_generation $hook
    ): void {
        global $PAGE;

        if (self::get_active_number($PAGE) === null) {
            return;
        }

        $PAGE->requires->css(new \moodle_url('/local/whatsappbutton/styles.css', [
            'v' => (string)get_config('local_whatsappbutton', 'version'),
        ]));
    }

    /**
     * Schedule the fixed WhatsApp button during HTML page rendering.
     *
     * @param \core\hook\output\before_standard_top_of_body_html_generation $hook Output hook.
     */
    public static function add_button(
        \core\hook\output\before_standard_top_of_body_html_generation $hook
    ): void {
        global $PAGE;

        $number = self::get_active_number($PAGE);
        if ($number === null) {
            return;
        }

        $config = get_config('local_whatsappbutton');
        $enablechat = !empty($config->enablechat);
        $colormode = (string)($config->colormode ?? 'light');
        if (!in_array($colormode, ['dark', 'light'], true)) {
            $colormode = 'light';
        }

        $templatecontext = [
            'number' => $number,
            'enablechat' => $enablechat,
            'directmessageencoded' => rawurlencode(trim((string)($config->directmessage ?? ''))),
            'colormode' => $colormode,
            'businessname' => trim((string)($config->businessname ?? '')) ?: 'Rurak',
            'greeting' => trim((string)($config->greeting ?? ''))
                ?: get_string('defaultgreeting', 'local_whatsappbutton'),
            'avatarurl' => self::get_avatar_url($config),
            'placeholder' => get_string('messageplaceholder', 'local_whatsappbutton'),
            'openlabel' => get_string('openwhatsapp', 'local_whatsappbutton'),
            'closelabel' => get_string('closechat', 'local_whatsappbutton'),
            'sendlabel' => get_string('sendmessage', 'local_whatsappbutton'),
            'inputlabel' => get_string('messageinputlabel', 'local_whatsappbutton'),
        ];

        $hook->add_html($hook->renderer->render_from_template(
            'local_whatsappbutton/widget',
            $templatecontext
        ));
        $PAGE->requires->js_call_amd('local_whatsappbutton/button', 'init');
    }

    /**
     * Build the pluginfile URL for the configured avatar.
     *
     * @param \stdClass $config Plugin settings.
     * @return string Empty when the person fallback icon should be used.
     */
    private static function get_avatar_url(\stdClass $config): string {
        $storedpath = trim((string)($config->avatar ?? ''));
        if ($storedpath === '') {
            return '';
        }

        $parts = explode('/', trim($storedpath, '/'));
        $filename = array_pop($parts);
        if ($filename === null || $filename === '') {
            return '';
        }

        $filepath = '/' . ($parts ? implode('/', $parts) . '/' : '');
        return \moodle_url::make_pluginfile_url(
            \context_system::instance()->id,
            'local_whatsappbutton',
            'avatar',
            0,
            $filepath,
            $filename,
            false
        )->out(false);
    }

    /**
     * Resolve the button's target number for the current page, if it should show at all.
     *
     * @param \moodle_page $page Current Moodle page.
     * @return string|null Validated WhatsApp number, or null if the button should not show here.
     */
    private static function get_active_number(\moodle_page $page): ?string {
        if (during_initial_install() || !get_config('local_whatsappbutton', 'version')) {
            return null;
        }

        $config = get_config('local_whatsappbutton');
        if (empty($config->enabled) || self::is_excluded_page($page)) {
            return null;
        }

        $number = phone::normalise((string)($config->number ?? ''));
        if (!phone::is_valid($number) || !self::is_enabled_for_page($page, $config)) {
            return null;
        }

        return $number;
    }

    /**
     * Never show on technical, embedded, login or administration pages.
     *
     * @param \moodle_page $page Current Moodle page.
     * @return bool Whether this page is excluded unconditionally.
     */
    private static function is_excluded_page(\moodle_page $page): bool {
        $pagetype = (string)$page->pagetype;
        $layout = (string)$page->pagelayout;

        if (in_array($layout, ['embedded', 'popup', 'print', 'maintenance'], true)) {
            return true;
        }

        foreach (['admin-', 'login-', 'webservice-', 'ajax-'] as $prefix) {
            if (strpos($pagetype, $prefix) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Apply the administrator's page-area choices.
     *
     * @param \moodle_page $page Current Moodle page.
     * @param \stdClass $config Plugin settings.
     * @return bool Whether the button is enabled on this page.
     */
    private static function is_enabled_for_page(\moodle_page $page, \stdClass $config): bool {
        if ($page->pagetype === 'site-index') {
            return !empty($config->showfrontpage);
        }

        if ($page->pagetype === 'my-index') {
            return !empty($config->showdashboard);
        }

        if (!empty($page->course) && $page->course->id > SITEID) {
            return !empty($config->showcourses);
        }

        return !empty($config->showother);
    }
}
