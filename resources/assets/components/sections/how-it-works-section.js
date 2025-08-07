import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class HowItWorksSection extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            display: flex;
            flex-direction: column;
            gap: 4em;
        }

        .content {
            display: flex;
            padding: 1px 0;
            border-bottom: 1px solid var(--color-border);
            border-top: 1px solid var(--color-border);
        }

        .dots {
            min-width: 120px;
        }

        .content .dots:nth-child(1) {
            border-right: 1px solid var(--color-border);
        }

        .inner {
            display: flex;
            flex-direction: column;
            flex: 1;
        }
    `];

    get content() {
        return [{
            headline: 'Saucer: The Core of Performance',
            text: 'At the heart of Boson PHP is saucer, a fast cross-platform C++ library. It allows us to create applications with minimal size and resource consumption, significantly outperforming Electron in terms of performance.',
        }, {
            headline: 'Saucer: The Core of Performance',
            text: 'At the heart of Boson PHP is saucer, a falications with minimal size and resource consumption, significantly outperforming Electron in terms of performance.',
        }, {
            headline: 'Saucer: The Core of Performance',
            text: 'At the heart of Boson antly outperforming Electron in terms of performance.',
        }, {
            headline: 'Saucer: The Core of Performance',
            text: 'At the heart of to create applications with minimal size and resource consumption, significantly outperforming Electron in terms of performance.',
        }, {
            headline: 'Saucer: The Core of Performance',
            text: 'At the heart of Boson PHP is saucer, a fast cross-platform C++ library. It allows us to create and resource consumption, significantly outperforming Electron in terms of performance.',
        }];
    }

    render() {
        return html`
            <section class="container">
                <div class="content">
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                    <div class="inner">
                        <horizontal-accordion .content=${this.content}></horizontal-accordion>
                    </div>
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                </div>
            </section>
        `;
    }
}

customElements.define('how-it-works-section', HowItWorksSection);
