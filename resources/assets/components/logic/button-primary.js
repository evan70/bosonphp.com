import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class ButtonPrimary extends LitElement {
    static properties = {
        href: {type: String},
        text: {type: String},
    };

    static styles = [sharedStyles, css`
        .button {
            transition-duration: 0.2s;
            background: var(--color-bg-button);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2em;
            padding: 1em;
            text-transform: uppercase;
        }

        .button:hover {
            background: var(--color-bg-button-hover);
        }

        .text {
            margin-left: 1em;
            color: var(--color-text-button);
        }

        .box {
            height: 35px;
            width: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-text-button);
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
                <span class="text">${this.text}</span>
                <div class="box">
                    <img class="img" src="/images/icons/arrow_primary.svg" alt="arrow_primary"/>
                </div>
            </a>
        `;
    }
}

customElements.define('button-primary', ButtonPrimary);
