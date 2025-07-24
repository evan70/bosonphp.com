import {css, html, LitElement} from 'lit';

import './dots-container.js';
import './header/button.js';
import './header/link.js';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class AppHeader extends LitElement {
    static properties = {
        isScrolled: {type: Boolean},
        isDocsOpen: {type: Boolean},
    };

    static styles = [sharedStyles, css`
    .container {
      height: 100px;
      line-height: 100px;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid var(--border-color-1);
      transition-duration: 0.2s;
      background: var(--bg-1-opacity);
      backdrop-filter: blur(14px);
      z-index: 10;

      .dots {
        height: inherit;
        aspect-ratio: 1 / 1;

        &:nth-child(1) {
          border-right: 1px solid var(--border-color-1);
        }
      }

      &.isScrolled {
        height: 70px;
        line-height: 70px;
      }
    }

    ::slotted(*) {
        height: 100%;
    }

    .nav {
      flex: 1;
      padding: 0 3em;
      display: flex;
      gap: 3em;
      border-right: 1px solid var(--border-color-1);
      align-self: stretch;
      align-items: center;
    }

    .button {
      all: unset;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 0.25em;
    }

    .isActive {
      color: var(--red);
    }

    .isRotated {
      transform: rotate(180deg);
    }


    .docs {
      position: relative;
    }
    .docsContent {
      position: absolute;
      top: 30px;
      border: 1px solid var(--border-color-1);
      left: 0;
      right: 0;
      transition-duration: 0.2s;
      padding: 1.25em;
      background: var(--bg-1);
      display: flex;
      flex-direction: column;
      opacity: 0;
      gap: 0.75em;
    }
    .isOpen {
      opacity: 1;
    }
  `];

    constructor() {
        super();
        this.isScrolled = false;
        this.isDocsOpen = false;
        this.handleScroll = this.handleScroll.bind(this);
        this.handleClickOutside = this.handleClickOutside.bind(this);
    }

    connectedCallback() {
        super.connectedCallback();
        window.addEventListener('scroll', this.handleScroll);
        this.handleScroll();
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        window.removeEventListener('scroll', this.handleScroll);
        document.removeEventListener('mousedown', this.handleClickOutside);
    }

    updated(changedProperties) {
        if (changedProperties.has('isDocsOpen')) {
            if (this.isDocsOpen) {
                document.addEventListener('mousedown', this.handleClickOutside);
            } else {
                document.removeEventListener('mousedown', this.handleClickOutside);
            }
        }
    }

    handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        this.isScrolled = scrollTop > 0;
    }

    handleClickOutside(event) {
        const docsElement = this.shadowRoot.querySelector('.docs');
        const path = event.composedPath();
        if (this.isDocsOpen && docsElement && !path.includes(docsElement)) {
            this.isDocsOpen = false;
        }
    }

    toggleDocs() {
        this.isDocsOpen = !this.isDocsOpen;
    }

    render() {
        return html`
            <header class="container ${this.isScrolled ? 'isScrolled' : ''}">
                <div class="dots">
                    <dots-container></dots-container>
                </div>

                <slot name="logo"></slot>

                <div class="nav">
                    <slot></slot>

                    <div class="docs">
                        <button
                                class="button link ${this.isDocsOpen ? 'isActive' : ''}"
                                @click=${this.toggleDocs}
                        >
                            Documentation
                            <img class="${this.isDocsOpen ? 'isRotated' : ''}" src="/images/icons/arrow_up_header.svg"
                                 alt="arrow_up"/>
                        </button>
                        <div class="docsContent ${this.isDocsOpen ? 'isOpen' : ''}">
                            <a class="link" href="/">Link 1</a>
                            <a class="link" href="/">Link 2</a>
                            <a class="link" href="/">Link 3</a>
                        </div>
                    </div>
                </div>

                <slot name="aside"></slot>

                <div class="dots">
                    <dots-container></dots-container>
                </div>
            </header>
        `;
    }
}

customElements.define('app-header', AppHeader);
