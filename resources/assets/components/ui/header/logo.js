import {css, html, LitElement} from 'lit';
import {sharedStyles} from "../../../utils/sharedStyles.js";

export class BosonHeaderLogo extends LitElement {
    static properties = {
        href: {type: String},
        image: {type: String},
    };

    static styles = [sharedStyles, css`
    .logo {
      height: inherit;
      border-right: 1px solid var(--border-color-1);
      padding: 0 3em;
      display: flex;
      align-items: center;
      transition: background .2s ease;

      &:hover {
        background: var(--bg-1-hover);
      }

      .img {
        height: 50%;
      }
    }
    `];

    constructor() {
        super();

        this.href = '/';
        this.image = '/images/logo.svg';
    }

    render() {
        return html`
            <a class="logo" href="${this.href}">
                <h1 style="display: none">BosonPHP</h1>
                <img class="img" src="${this.image}" alt="logo" />
            </a>
        `;
    }
}

customElements.define('boson-header-logo', BosonHeaderLogo);
