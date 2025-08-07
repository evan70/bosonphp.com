import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class ButtonSecondary extends LitElement {
    static properties = {
        href: {type: String},
        text: {type: String},
    };

    static styles = [sharedStyles, css`
        .button {
            transition-duration: 0.2s;
            background: var(--color-bg-button-secondary);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2em;
            padding: 1em;
            text-transform: uppercase;
        }

        .button:hover {
            background: var(--color-bg-button-secondary-hover);
        }

        .text {
            margin-left: 1em;
            color: var(--color-text-button-secondary);
        }

        .box {
            height: 35px;
            width: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-text-button-secondary);
        }
    `];

    constructor() {
        super();
        this.href = '/';
        this.text = '';
    }

    render() {
        return html`
            <a href="${this.href}" class="button">
                <span class="text">
                    ${this.text}
                    <slot></slot>
                </span>
                <div class="box">
                    <img class="img" src="/images/icons/arrow_secondary.svg" alt="arrow_secondary"/>
                </div>
            </a>
        `;
    }
}

customElements.define('button-secondary', ButtonSecondary);
