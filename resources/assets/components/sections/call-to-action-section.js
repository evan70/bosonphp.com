import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class CallToActionSection extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            padding-bottom: 8em;
            background-size: 900px 900px;
            background: url("/images/hero.svg") no-repeat 115% 0;
        }

        .wrapper {
            width: var(--width-content);
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 3em;
            align-items: flex-start;
        }

        .red {
            color: var(--color-text-brand);
        }
    `];

    render() {
        return html`
            <section class="container">
                <div class="wrapper">
                    <div class="text">
                        <h3>
                            If you are a PHP developer, you can already</br>
                            make native cross-platform applications.</br>
                            Boson PHP makes it possible!</br>
                            <span class="red">Get started right now!</span>
                        </h3>
                    </div>
                    <button-primary text="Try Boson For Free" href="/"></button-primary>
                </div>
            </section>
        `;
    }
}

customElements.define('call-to-action-section', CallToActionSection);
