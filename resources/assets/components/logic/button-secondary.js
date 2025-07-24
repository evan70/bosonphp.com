import { LitElement, html, css } from 'lit';
import {sharedStyles} from "../../utils/sharedStyles.js";

export class ButtonSecondary extends LitElement {
    static properties = {
        href: { type: String },
        text: { type: String }
    };

    static styles = [
        sharedStyles,
        css`
    .button {
      transition-duration: 0.2s;
      background: var(--grey-bg);
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 2em;
      padding: 1em;
      text-transform: uppercase;
    }
    .button:hover {
      background: var(--grey-bg-hover);
    }
    .text {
      margin-left: 1em;
      color: var(--color-headline-1);
    }
    .box {
      height: 35px;
      width: 35px;
      display: flex;
      justify-content: center;
      align-items: center;
      background: var(--color-headline-1);
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
          <img class="img" src="/images/icons/arrow_secondary.svg" alt="arrow_secondary" />
        </div>
      </a>
    `;
    }
}

customElements.define('button-secondary', ButtonSecondary);