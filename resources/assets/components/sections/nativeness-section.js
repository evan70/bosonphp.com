import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class NativenessSection extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            display: flex;
            flex-direction: column;
            margin-bottom: 2em;
        }

        .top {
            display: flex;
            width: var(--width-content);
            margin: 0 auto;
            gap: 3em;
        }

        .left {
            display: flex;
            flex-direction: column;
            flex: 3;
            align-items: flex-start;
            gap: 2em;
        }

        .title {
            font-size: clamp(3rem, 1vw + 3.5rem, 5rem);
            line-height: 1.1;
            font-weight: 500;
        }

        .right {
            flex: 2;
            display: flex;
            flex-direction: column;
            font-size: clamp(1rem, 0.55vw + 0.55rem, 2rem);
            justify-content: flex-end;
            line-height: 1.75;
        }

        .content {
            height: 40vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    `];

    render() {
        return html`
            <section class="container">
                <div class="top">
                    <div class="left">
                        <subtitle-component name="Nativeness"></subtitle-component>
                        <h1 class="title">
                            Familiar PHP. Now for desktop and mobile applications.
                        </h1>
                    </div>
                    <div class="right">
                        <p>"What makes you think PHP is only for the web?"</p>
                        <p>– Boson is changing the rules of the game!</p>
                    </div>
                </div>
                <div class="content">
                    TODO
                </div>
            </section>
        `;
    }
}

customElements.define('nativeness-section', NativenessSection);
