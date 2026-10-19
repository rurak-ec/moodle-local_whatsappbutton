# Changelog

All notable changes to this plugin are documented here.

## 1.4.5 - 2026-10-19

- The typing bubble now plays only the first time the panel opens in a conversation. Opening it again shows the welcome message at once.
- The typing bubble shows for 1 second instead of about 1.5 seconds.
- A conversation belongs to a browser tab: it continues while the visitor moves between Moodle pages, and starts again when the tab is reloaded or closed and reopened.
- Closing the panel while the bubble is still typing counts as having received the message, so reopening shows it straight away.
- The conversation state is kept in `sessionStorage` (separate from the notification dot) and falls back to once per page load when storage is unavailable.

## 1.4.4 - 2026-10-19

- The welcome message now arrives like an incoming WhatsApp message: when the panel opens, a bubble with three bouncing dots shows for about 1.5 seconds and the message then pops in. It is skipped when the visitor prefers reduced motion. (It played on every opening in this release; 1.4.5 limits it to the first.)
- The message area is a polite live region, so screen readers announce the greeting when it arrives. The typing bubble is hidden from assistive technology.
- The online status and message timestamp stay removed (see 1.4.0).
- Restore the lazy document click and Escape listeners and the notification timer in the AMD source, which the 1.4.3 build already shipped but the source had lost.

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
