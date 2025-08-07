import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class HeroSection extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            display: flex;
            flex-direction: column;
            margin: 0 auto;
            min-height: calc(100vh - 100px);
        }

        .top {
            display: flex;
            flex-direction: row;
            align-items: center;
            flex: 1;
            gap: 2em;
            justify-content: space-between;
            margin: 0 auto;
            padding: 3em 0;
            max-width: var(--width-max);
            width: var(--width-content);
        }

        .white {
            color: var(--color-text);
        }

        .text {
            flex: 3;
            display: flex;
            flex-direction: column;
            gap: 3em;
        }

        .img {
            flex: 2;
        }

        .headlines {
            line-height: 1.1;
        }

        .headlines h1 {
            color: var(--color-text-brand);
        }

        .description {
            width: 80%;
        }

        .buttons {
            display: flex;
            flex-direction: row;
            gap: 3em;
        }

        .bottom {
            display: flex;
            align-items: center;
            border-top: 1px solid var(--color-border);
            text-transform: uppercase;
            width: 100%;
        }

        .bottom .discover {
            width: 100%;
            transition-duration: 0.2s;
            font-family: var(--font-title), sans-serif;
        }

        .bottom .discover-container {
            transition-duration: 0.2s;
            max-width: var(--width-max);
            width: var(--width-content);
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 3em 0;
        }

        .bottom .discover:hover {
            background-color: var(--color-bg-hover);
        }

        .bottom .discover:hover .discover-container {
            padding: 3em 2em;
        }

        .logo-container {
            display: flex;
            aspect-ratio: 1/1;
        }

        @media (orientation: portrait) {
            .top {
                flex-direction: column;
                padding: 5em 0;
            }
            .text {
                margin: 0 1em;
            }
            .buttons {
                flex-direction: column;
                align-items: flex-start;
                gap: 1em;
            }
            .img {
                max-width: 90vw;
            }
            .bottom {
                padding: 3em 1em;
            }
        }
    `];

    render() {
        return html`
            <section class="container">
                <div class="top">
                    <div class="text">
                        <div class="headlines">
                            <h1>Go Native. </br><span class="white">Stay PHP</span></h1>
                        </div>
                        <p class="description">Turn your PHP project into cross-platform, compact, fast, native
                            applications for Windows, macOS, Linux, Android and iOS.</p>
                        <div class="buttons">
                            <button-primary href="/" icon="/images/icons/arrow_primary.svg">
                                Try Boson for Free
                            </button-primary>

                            <button-primary type="secondary" href="/" icon="/images/icons/arrow_secondary.svg">
                                Watch Presentation
                            </button-primary>
                        </div>
                    </div>
                    <div class="img">
                        <div class="logo-container">
<!--                            <logo-component></logo-component>-->
                            <logo-animated-transform-component></logo-animated-transform-component>
<!--                            <logo-animated-opacity-component></logo-animated-opacity-component>-->
                        </div>
                    </div>
                </div>

                <aside class="bottom">
                    <a href="#nativeness" class="discover">
                        <span class="discover-container">
                            <span class="discover-text">Discover more about boson</span>
                            <img class="discover-icon" src="/images/icons/arrow_down.svg" alt="arrow_down"/>
                        </span>
                    </a>
                </aside>
            </section>
        `;
    }
}

customElements.define('hero-section', HeroSection);
