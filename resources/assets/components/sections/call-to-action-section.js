import {css, html, LitElement} from 'lit';

import '../logic/button-primary.js';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class CallToActionSection extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            padding-bottom: 8em;
            background-size: 900px 900px;
            background: url("/images/hero.svg") no-repeat 115% 0;
        }

        .wrapper {
            width: var(--content-width);
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 3em;
            align-items: flex-start;
        }

        .red {
            color: var(--red);
        }

        .text h1 {
            font-size: max(2rem, min(2rem + 1vw, 5rem));
            font-weight: 500;
            line-height: 1.1;
        }
    `];

    render() {
        return html`
            <section class="container">
                <div class="wrapper">
                    <div class="text">
                        <h1>If you are a PHP developer, you can already</h1>
                        <h1>make native cross-platform applications.</h1>
                        <h1>Boson PHP makes it possible!</h1>
                        <h1 class="red">Get started right now!</h1>
                    </div>
                    <button-primary text="Try Boson For Free" href="/"></button-primary>
                </div>
            </section>
        `;
    }
}

customElements.define('call-to-action-section', CallToActionSection);
