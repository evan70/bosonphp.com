import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class RightChoiceSection extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            background-size: 100% auto;
            background: url("/images/right_choice_bg.png") no-repeat top;
            height: 200vh;
        }

        .top {
            margin: 6em;
            display: flex;
            font-size: max(4rem, min(4.5rem + 1vw, 7rem));
            line-height: 1.1;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .red {
            color: var(--color-text-brand);
        }

        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    `];

    render() {
        return html`
            <section class="container">
                <div class="top">
                    <h1>Why is Boson PHP</h1>
                    <h1 class="red">the right choice</h1>
                    <h1>for you?</h1>
                </div>
                <div class="content">
                    TODO
                </div>
            </section>
        `;
    }
}

customElements.define('right-choice-section', RightChoiceSection);
