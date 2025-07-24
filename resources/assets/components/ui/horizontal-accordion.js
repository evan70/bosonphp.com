import {css, html, LitElement} from 'lit';
import {sharedStyles} from "../../utils/sharedStyles.js";

export class HorizontalAccordion extends LitElement {
    static properties = {
        content: {type: Array},
        openIndex: {type: Number},
    };

    static styles = [sharedStyles, css`
        .accordion {
            display: flex;
            height: 24rem;
            flex: 1;
        }

        .element {
            border-right: 1px solid var(--border-color-1);
            transition-duration: 0.3s;
        }

        .elementOpen {
            flex: 1;
        }

        .elementClosed {
            width: 5em;
            cursor: pointer;
        }

        .elementClosed:hover {
            background: var(--bg-1-hover);
        }

        .elementOpen .elementContent {
            padding: 2em 3em;
        }

        .elementClosed .elementContent {
            padding: 2em 0;
        }

        .elementContent {
            transition-duration: 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .openTop {
            display: flex;
            align-items: center;
            gap: 3em;
            animation: appear 1s forwards;
            height: 60px;
        }

        .closedTop {
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .content {
            flex: 1;
            width: 700px;
            animation: appear 1s forwards;
            margin-left: 4.5em;
            display: flex;
            align-items: flex-end;
            font-size: max(1rem, min(.55vw + .55rem, 2rem));
            line-height: 1.75;
        }

        .headline {
            font-size: max(1.5rem, min(2rem + 1vw, 2.25rem));
            font-weight: 500;
        }

        .number {
            font-size: max(1.5rem, min(2rem + 1vw, 2rem));
            color: var(--red);
            transition-duration: 0.2s;
        }

        .elementClosed .elementContent .closedTop .number {
            color: var(--color-paragraph-1);
        }

        .elementClosed:hover .elementContent .closedTop .number {
            color: var(--red);
        }

        .collapsedContent {
            flex: 1;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            filter: grayscale(100%);
            transition-duration: 0.2s;
        }

        .elementClosed:hover .elementContent .collapsedContent {
            filter: grayscale(0%);
        }

        @keyframes appear {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    `];

    constructor() {
        super();
        this.content = [];
        this.openIndex = 0;
    }

    handleElementClick(index) {
        this.openIndex = index;
    }

    renderElement(item, index) {
        const isOpen = this.openIndex === index;

        return html`
            <div
                class="element ${isOpen ? 'elementOpen' : 'elementClosed'}"
                @click=${() => this.handleElementClick(index)}
            >
                <div class="elementContent">
                    ${isOpen ? html`
                        <div class="openTop">
                            <span class="number">0${index + 1}</span>
                            <h3 class="headline">${item.headline}</h3>
                        </div>
                    ` : html`
                        <div class="closedTop">
                            <span class="number">0${index + 1}</span>
                        </div>
                    `}

                    ${isOpen ? html`
                        <div class="content">
                            <p class="text">${item.text}</p>
                        </div>
                    ` : html`
                        <div class="collapsedContent">
                            <img src="/images/icons/plus.svg" alt="plus"/>
                        </div>
                    `}
                </div>
            </div>
        `;
    }

    render() {
        return html`
            <div class="accordion">
                ${this.content.map((item, index) => this.renderElement(item, index))}
            </div>
        `;
    }
}

customElements.define('horizontal-accordion', HorizontalAccordion);
