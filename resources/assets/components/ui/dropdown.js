import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class BosonDropdown extends LitElement {
    static properties = {};

    static styles = [sharedStyles, css`
        details > summary {
            list-style-type: '';
        }

        details > summary::-webkit-details-marker,
        details > summary::marker {
            display: none;
        }

        .dropdown {
            position: relative;
            padding-right: 24px;
        }

        .dropdown-list {
            position: absolute;
            line-height: 42px;
            background: var(--color-bg-layer);
            border: 2px solid var(--color-border);
            padding: 4px;
            display: flex;
            min-width: 200px;
            flex-direction: column;
            flex-wrap: nowrap;
            margin-top: -21px;
        }

        .dropdown-list::before {
            position: absolute;
            content: "";
            background: var(--color-border);
            top: 10px;
            left: 10px;
            z-index: -1;
            height: 100%;
            width: 100%;
        }

        .dropdown-list ::slotted(boson-button) {
            justify-content: flex-start;
            height: 32px;
            line-height: 32px;
        }

        details:hover > summary ::slotted(boson-button) {
            background: var(--color-border);
        }
    `];

    constructor() {
        super();
    }

    onMouseEnter(e) {
        e.target.setAttribute('open', 'open');
    }

    onMouseLeave(e) {
        e.target.removeAttribute('open');
    }

    render() {
        return html`
            <details class="dropdown"
                     @mouseenter="${this.onMouseEnter}"
                     @mouseleave="${this.onMouseLeave}">

                <summary class="dropdown-summary">
                    <slot name="summary"></slot>
                </summary>

                <nav class="dropdown-list">
                    <slot></slot>
                </nav>
            </details>
        `;
    }
}

customElements.define('boson-dropdown', BosonDropdown);
