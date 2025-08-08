import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class DocsToc extends LitElement {
    static styles = [sharedStyles, css`
        :host {
            display: flex;
            flex-direction: column;
        }

        .toc-content-container,
        .toc-title-container {
            width: var(--width-content);
            max-width: var(--width-max);
            margin: 0 auto;
        }

        .toc-title-container {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
        }

        ::slotted([slot="title"]) {
            line-height: 76px !important;
            display: inline-block;
            background: var(--color-bg);
            padding: 0 1em !important;
        }

        .toc-title {
            background: url(/images/icons/dots.svg) center center repeat;
        }

        .toc-content {
            border: solid 1px var(--color-border);
        }

        .toc-content-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }

        .toc-content-container ::slotted(article) {
            padding: 3em;
        }

        @media (max-width: 1440px) {
            .toc-content-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 1200px) {
            .toc-content-container {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 900px) {
            .toc-content-container {
                display: grid;
                grid-template-columns: 1fr;
            }
        }
    `];

    render() {
        return html`
            <hgroup class="toc-title">
                <span class="toc-title-container">
                    <slot name="title"></slot>
                </span>
            </hgroup>

            <section class="toc-content">
                <span class="toc-content-container">
                    <slot></slot>
                </span>
            </section>
        `;
    }
}

customElements.define('boson-docs-toc', DocsToc);
