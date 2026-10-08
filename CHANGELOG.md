# Changelog

All notable changes to this plugin are documented here.

## 1.4.3 - 2026-10-08

- Performance: Implement request-level memoization in output hooks to eliminate redundant configuration parsing and phone validation.
- Performance: Lazy-bind global document click and Escape key listeners only while the chat dialog is actively open.
- Performance: Add CSS containment (`contain: layout;`, `isolation: isolate;`, `contain: layout style;`) and hardware GPU acceleration (`will-change: transform, opacity;`) to prevent full-page layout reflows.
- Performance: Add `touch-action: manipulation;` on interactive buttons to remove mobile 300ms click delay.
- Compatibility: Formally integrate Moodle 5.3 LTS (`MOODLE_503_STABLE`) in `moodle-plugin-ci` matrix across PHP 8.3 and PHP 8.4.

## 1.4.1 - 2026-10-06

- Fix the profile image returning 404: the pluginfile callback now accepts the item id (`/0/`) that Moodle puts in the URL.
- Remove the white ring around the red notification dot.

## 1.4.0 - 2026-08-27

- Remove the online status and message timestamp from the widget and administration settings.
- Vertically centre the display name beside the profile image.
- Declare the explicit WhatsApp message transfer through Moodle's Privacy API.
- Add Moodle Plugin CI for Moodle 4.5–5.2, plus non-blocking Moodle 5.3-dev tracking.
- Add PHPUnit coverage, Composer metadata and public project documentation.

## 1.3.3 - 2026-08-27

- Match the light colour scheme to the familiar WhatsApp palette.
- Keep the message input at a fixed height and centre its text vertically.
- Use manual light or dark mode, with light as the default.

## 1.3.0 - 2026-08-27

- Add the optional chat panel, configurable identity, avatar and welcome message.
- Add direct-button mode, disabled chat by default and optional direct message.
