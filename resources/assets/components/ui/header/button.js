import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../../utils/sharedStyles.js";

export class BosonHeaderButton extends LitElement {
    static properties = {
        href: {type: String},
        external: {type: Boolean},
    };

    static styles = [sharedStyles, css`
        .button {
            height: inherit;
            border-right: 1px solid var(--color-border);
            padding: 0 3em;
            display: flex;
            align-items: center;
            transition: background .2s ease;
            text-transform: uppercase;
            gap: 0.75em;
        }

        .button:hover {
            background: var(--color-bg-hover);
        }

        ::slotted(img.logo) {
            height: 50%;
        }
    `];

    constructor() {
        super();

        this.href = '/';
        this.external = false;
    }

    render() {
        return html`
            <a class="button"
               href="${this.href}"
               target="${this.external ? '_blank' : '_self'}">
                <slot></slot>
            </a>
        `;
    }
}

customElements.define('boson-header-button', BosonHeaderButton);
