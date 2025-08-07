import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class ButtonPrimary extends LitElement {
    static properties = {
        href: {type: String},
        type: {type: String},
        icon: {type: String},
    };

    static styles = [sharedStyles, css`
        .button {
            font-family: var(--font-title), sans-serif;
            letter-spacing: 1px;
            color: var(--color-text-button);
            transition-duration: 0.2s;
            background: var(--color-bg-button);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2em;
            padding: 0 2em;
            text-transform: uppercase;
            line-height: 56px;
            height: 56px;
            white-space: nowrap;
        }

        .button:hover {
            background: var(--color-bg-button-hover);
        }

        .icon {
            aspect-ratio: 1 / 1;
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-text-button);
            margin: 0 -1em 0 -.5em;
        }

        .button.button-secondary {
            background: var(--color-bg-button-secondary);
            color: var(--color-text);
        }

        .button.button-secondary:hover {
            background: var(--color-bg-button-secondary-hover);
        }

        .button.button-secondary .text {
            color: var(--color-text-button-secondary);
        }

        .button.button-secondary .icon {
            background: var(--color-text-button-secondary);
        }
    `];

    constructor() {
        super();

        this.href = '/';
        this.type = 'primary';
        this.icon = '';
    }

    render() {
        return html`
            <a href="${this.href}" class="button button-${this.type}">
                <slot></slot>

                <span class="icon" style="${this.icon === '' ? 'display:none': ''}">
                    <img class="img" src="${this.icon}" alt="arrow" />
                </span>
            </a>
        `;
    }
}

customElements.define('button-primary', ButtonPrimary);
