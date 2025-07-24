import {css, html, LitElement} from 'lit';
import './link.js';
import {sharedStyles} from "../../../utils/sharedStyles.js";

export class BosonHeaderDropdown extends LitElement {
    static properties = {
    };

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
      border: solid 2px var(--red);
      border-right-color: transparent;
      border-bottom-color: transparent;
      transition: .2s ease;

      position: absolute;
      top: 50%;
      right: -14px;
      margin-top: -2.2px;

      transform-origin: 2px 2px;
      transform: rotate(225deg);
    }

    .dropdown-list {
      position: absolute;
      line-height: 42px;
      background: var(--bg-dark);
      border: 1px solid var(--grey-bg);
      padding: 10px 15px;
      display: flex;
      min-width: 200px;
      flex-direction: column;
      flex-wrap: nowrap;
      margin-top: -20px;
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
