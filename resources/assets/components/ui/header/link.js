import {css, html, LitElement} from 'lit';
import {sharedStyles} from "../../../utils/sharedStyles.js";

export class BosonHeaderLink extends LitElement {
    static properties = {
        href: {type: String},
        external: {type: Boolean},
        active: {type: Boolean},
    };

    static styles = [sharedStyles, css`
    .link {
      color: var(--color-paragraph-1);
      transition-duration: 0.2s;
      text-transform: uppercase;

      &.active,
      &:hover {
        color: var(--red);
      }
    }
    `];

    constructor() {
        super();

        this.href = '/';
        this.external = false;
        this.active = false;
    }

    render() {
        return html`
            <a class="link ${this.active ? 'active' : ''}"
               href="${this.href}"
               target="${this.external ? '_blank' : '_self'}">
                <slot></slot>
            </a>
        `;
    }
}

customElements.define('boson-header-link', BosonHeaderLink);
