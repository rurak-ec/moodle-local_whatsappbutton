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
 * Controls the floating WhatsApp widget rendered by Moodle.
 *
 * @module     local_whatsappbutton/button
 * @copyright  2026 Rurak
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

const SELECTORS = {
    WIDGET: '[data-region="whatsapp-widget"]',
    CHAT: '[data-region="whatsapp-chat"]',
    INPUT: '[data-region="message-input"]',
    NOTIFICATION: '[data-region="notification-dot"]',
    TOGGLE: '[data-action="toggle-chat"]',
    CLOSE: '[data-action="close-chat"]',
    SEND: '[data-action="send-message"]',
};

const STORAGE_KEY = 'local_whatsappbutton_opened';
const CLOSE_TRANSITION_MS = 300;

/**
 * Read sessionStorage without breaking the widget in restricted browsers.
 *
 * @return {boolean} Whether this chat has already been opened this session.
 */
const hasOpenedThisSession = () => {
    try {
        return window.sessionStorage.getItem(STORAGE_KEY) === 'true';
    } catch {
        return false;
    }
};

/**
 * Remember that the chat was opened, when sessionStorage is available.
 */
const rememberOpened = () => {
    try {
        window.sessionStorage.setItem(STORAGE_KEY, 'true');
    } catch {
        // Storage can be unavailable in privacy modes. The chat still works.
    }
};

/**
 * Open a protected wa.me link, optionally including a message.
 *
 * @param {string} number Validated digits-only WhatsApp number.
 * @param {string} message Optional message.
 */
const openWhatsApp = (number, message = '') => {
    const cleanMessage = message.trim();
    const url = cleanMessage
        ? `https://wa.me/${number}?text=${encodeURIComponent(cleanMessage)}`
        : `https://wa.me/${number}`;
    const openedWindow = window.open(url, '_blank', 'noopener,noreferrer');
    if (openedWindow) {
        openedWindow.opener = null;
    }
};

/**
 * Read the URL-encoded direct message rendered by PHP.
 *
 * @param {HTMLElement} widget Widget root.
 * @return {string} Decoded message or an empty string.
 */
const getDirectMessage = (widget) => {
    try {
        return decodeURIComponent(widget.dataset.directMessage || '');
    } catch {
        return '';
    }
};

/**
 * Initialise the accessible floating widget once per page.
 */
export const init = () => {
    const widget = document.querySelector(SELECTORS.WIDGET);
    if (!widget || widget.dataset.initialised === 'true') {
        return;
    }

    const toggle = widget.querySelector(SELECTORS.TOGGLE);
    const number = widget.dataset.phone || '';
    if (!toggle || !/^\d{8,15}$/.test(number)) {
        return;
    }

    const chatEnabled = widget.dataset.chatEnabled === '1';
    if (!chatEnabled) {
        widget.dataset.initialised = 'true';
        const directMessage = getDirectMessage(widget);
        toggle.addEventListener('click', (event) => {
            event.stopPropagation();
            openWhatsApp(number, directMessage);
        });
        return;
    }

    const chat = widget.querySelector(SELECTORS.CHAT);
    const input = widget.querySelector(SELECTORS.INPUT);
    const close = widget.querySelector(SELECTORS.CLOSE);
    const send = widget.querySelector(SELECTORS.SEND);
    const notification = widget.querySelector(SELECTORS.NOTIFICATION);
    if (!chat || !input || !close || !send) {
        return;
    }

    widget.dataset.initialised = 'true';
    let isOpen = false;
    let closeTimer = null;
    let notifTimer = null;

    const hideChat = () => {
        if (!isOpen) {
            chat.hidden = true;
            chat.setAttribute('inert', '');
        }
    };

    const handleDocumentClick = (event) => {
        if (isOpen && !widget.contains(event.target)) {
            closeChat();
        }
    };

    const handleDocumentKeydown = (event) => {
        if (event.key === 'Escape' && isOpen) {
            event.preventDefault();
            closeChat();
        }
    };

    const openChat = () => {
        if (isOpen) {
            return;
        }

        isOpen = true;
        if (closeTimer !== null) {
            window.clearTimeout(closeTimer);
            closeTimer = null;
        }
        if (notifTimer !== null) {
            window.clearTimeout(notifTimer);
            notifTimer = null;
        }

        chat.hidden = false;
        chat.removeAttribute('inert');

        window.requestAnimationFrame(() => {
            chat.classList.add('is-visible');
            toggle.setAttribute('aria-expanded', 'true');
            window.requestAnimationFrame(() => input.focus());
        });

        // Add document listeners only while dialog is active to prevent any background overhead.
        document.addEventListener('click', handleDocumentClick);
        document.addEventListener('keydown', handleDocumentKeydown);

        notification?.classList.remove('is-visible');
        rememberOpened();
    };

    const closeChat = () => {
        if (!isOpen) {
            return;
        }

        isOpen = false;
        // Clean up global document listeners immediately when dialog is closed.
        document.removeEventListener('click', handleDocumentClick);
        document.removeEventListener('keydown', handleDocumentKeydown);

        chat.classList.remove('is-visible');
        toggle.setAttribute('aria-expanded', 'false');
        closeTimer = window.setTimeout(hideChat, CLOSE_TRANSITION_MS);
        toggle.focus();
    };

    const sendMessage = () => {
        const message = input.value.trim();
        if (!message) {
            input.setAttribute('aria-invalid', 'true');
            input.focus();
            return;
        }

        openWhatsApp(number, message);
        input.value = '';
        input.removeAttribute('aria-invalid');
        closeChat();
    };

    toggle.addEventListener('click', (event) => {
        event.stopPropagation();
        if (isOpen) {
            closeChat();
        } else {
            openChat();
        }
    });

    close.addEventListener('click', (event) => {
        event.stopPropagation();
        closeChat();
    });

    send.addEventListener('click', (event) => {
        event.stopPropagation();
        sendMessage();
    });

    input.addEventListener('input', () => {
        input.removeAttribute('aria-invalid');
    });

    input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            sendMessage();
        }
    });

    if (!hasOpenedThisSession() && notification) {
        notifTimer = window.setTimeout(() => {
            if (!hasOpenedThisSession() && notification.isConnected) {
                notification.classList.add('is-visible');
            }
        }, 5000);
    }
};
