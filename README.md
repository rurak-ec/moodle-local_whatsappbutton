# WhatsApp button for Moodle

[![Moodle plugin CI](https://github.com/rurak-ec/moodle-local_whatsappbutton/actions/workflows/moodle-plugin-ci.yml/badge.svg)](https://github.com/rurak-ec/moodle-local_whatsappbutton/actions/workflows/moodle-plugin-ci.yml)
[![License: GPL v3 or later](https://img.shields.io/badge/License-GPL%20v3%2B-blue.svg)](LICENSE)

`local_whatsappbutton` adds a configurable floating WhatsApp button to ordinary Moodle pages. It can
open WhatsApp directly or display a small message panel before redirecting the visitor to `wa.me`.

## Features

- Validates and stores an international destination number as 8–15 digits.
- Shows the button on the site home, Dashboard, course pages and/or other public pages.
- Always excludes administration, login, embedded, popup, print, maintenance and technical pages.
- Direct mode opens WhatsApp with an optional administrator-defined message.
- Optional chat mode provides a welcome message, fixed-height input, keyboard controls and an
  accessible dialog. The welcome message arrives with a WhatsApp-style typing bubble (1 second) and
  pop-in animation the first time the panel opens in a browser tab (reloading or closing the tab starts a
  new conversation); later openings show it at once. The animation is skipped when the visitor
  prefers reduced motion.
- Configurable display name, profile image and manual light or dark colour scheme.
- Uses Moodle's File API, output hooks, Mustache templates, AMD modules and Privacy API.
- Stores no visitor messages and requires no WhatsApp Business API credentials or paid subscription.

## Requirements and compatibility

- Moodle 4.5, 5.0, 5.1, 5.2 or 5.3 (LTS).
- PHP 8.1, 8.2, 8.3 or 8.4 (as required by the selected Moodle version).
- A destination number that can receive WhatsApp messages.

The CI workflow uses official [`moodlehq/moodle-plugin-ci`](https://github.com/moodlehq/moodle-plugin-ci) to validate every currently maintained Moodle release against PostgreSQL and MariaDB, adhering strictly to Moodle Developer Documentation ([moodledev.io](https://moodledev.io)).

## Performance and zero-overhead architecture

The plugin is engineered for zero measurable impact on Moodle page rendering and responsiveness:

- **Request-level memoization:** Hook callbacks memoize the active number and plugin configuration in memory. Resolution logic executes only once per HTTP request; subsequent hook invocations return in $O(1)$ without repeating database calls or regex operations.
- **Fast early returns:** Immediately aborts execution on administration, login, AJAX, and webservice requests before parsing configuration or inspecting page layouts.
- **Lazy event listeners:** Global `document` click and `Escape` key listeners are attached only while the chat dialog is open and cleanly unregistered upon closing. Zero JavaScript runs during ordinary typing, form submissions, or forum navigation.
- **Strict CSS containment:** Uses CSS `contain: layout;`, `isolation: isolate;` on the widget root and `contain: layout style; will-change: transform, opacity;` on the dialog to prevent full-page layout thrashing or browser repaints during transitions.
- **Mobile responsiveness:** Employs `touch-action: manipulation;` on all interactive buttons to eliminate the mobile 300ms click delay.

## Installation

1. Download the release ZIP named `local_whatsappbutton.zip`.
2. Install it from **Site administration → Plugins → Install plugins**; alternatively, extract the
   plugin to `local/whatsappbutton`.
3. Complete the Moodle upgrade from the notifications page.
4. Open **Site administration → Plugins → Local plugins → WhatsApp button** and configure the
   destination number and visibility.

The distributed ZIP works without Composer, Node.js or any post-install build step.

## Privacy

Moodle does not store messages entered by visitors. When a visitor explicitly opens WhatsApp or
sends a message, their browser navigates to `https://wa.me/<number>` and may include the selected
message in the URL. The plugin declares this external destination through Moodle's Privacy API.
WhatsApp then processes the request under its own privacy terms.

## Accessibility and security

- All controls have accessible labels and keyboard focus styles.
- The optional panel uses dialog semantics, supports Escape and restores focus when closed.
- Phone numbers are normalised and validated before being placed in a URL.
- Messages are URL-encoded and external windows use `noopener,noreferrer`.
- User-provided text is escaped by Mustache and is never rendered as HTML.

## Support

Report bugs and request features in the [public issue tracker](https://github.com/rurak-ec/moodle-local_whatsappbutton/issues).
Security reports should follow [SECURITY.md](SECURITY.md).

## License and trademark notice

GNU GPL v3 or later. See [LICENSE](LICENSE).

WhatsApp is a trademark of Meta Platforms, Inc. This project is an independent Moodle plugin and is
not affiliated with, endorsed by or sponsored by Meta or WhatsApp.
