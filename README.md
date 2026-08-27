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
  accessible dialog.
- Configurable display name, profile image and manual light or dark colour scheme.
- Uses Moodle's File API, output hooks, Mustache templates, AMD modules and Privacy API.
- Stores no visitor messages and requires no WhatsApp Business API credentials or paid subscription.

## Requirements and compatibility

- Moodle 4.5, 5.0, 5.1 or 5.2.
- PHP version supported by the selected Moodle release.
- A destination number that can receive WhatsApp messages.

The CI matrix tests every currently maintained Moodle series on PostgreSQL and MariaDB. A
non-blocking job also tracks Moodle `main` (currently 5.3-dev) to identify upcoming compatibility
changes early. Development-branch testing is an early warning and does not claim support for an
unreleased Moodle version.

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
