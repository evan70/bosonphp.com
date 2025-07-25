import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../../utils/sharedStyles.js";

export class BosonHeaderDropdown extends LitElement {
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
            padding-right: 20px;
        }

        .dropdown:hover .dropdown-summary::after {
            transform: rotate(45deg);
        }

        .dropdown-summary {
            position: relative;
        }

        .dropdown-summary::after {
            content: '';
            width: 3px;
            height: 3px;
            display: block;
            border: solid 2px var(--color-text-brand);
            border-right-color: transparent;
            border-bottom-color: transparent;
            transition: .2s ease;
            border-radius: 1px;
            position: absolute;
            top: 50%;
            right: -20px;
            margin-top: -2.2px;
            transform-origin: 2px 2px;
            transform: rotate(225deg);
        }

        .dropdown-list {
            position: absolute;
            line-height: 42px;
            background: var(--color-bg-layer);
            border: 1px solid var(--color-border);
            padding: 10px 20px;
            display: flex;
            min-width: 200px;
            flex-direction: column;
            flex-wrap: nowrap;
            top: 50%;
            margin-top: 15px;
        }

        ::slotted(*) {
            white-space: nowrap;
        }

        ::slotted(strong) {
            text-transform: uppercase;
            color: var(--color-text-secondary);
            font-size: 90%;
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

customElements.define('boson-header-dropdown', BosonHeaderDropdown);
