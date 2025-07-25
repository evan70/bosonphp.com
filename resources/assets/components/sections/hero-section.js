import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class HeroSection extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            display: flex;
            flex-direction: column;
            width: var(--width-content);
            margin: 0 auto;
        }

        .top {
            display: flex;
            flex-direction: row;
            align-items: center;
            flex: 1;
            gap: 2em;
            justify-content: space-between;
            padding: 8em 0;
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
            font-size: clamp(4rem, 1vw + 4.5rem, 7rem);
            line-height: 1.1;
        }

        .headlines h1:nth-child(1) {
            color: var(--color-text-brand);
        }

        .description {
            width: 80%;
            line-height: 1.75;
            font-size: clamp(1rem, 0.55vw + 0.55rem, 2rem);
        }

        .buttons {
            display: flex;
            flex-direction: row;
            gap: 3em;
        }

        .bottom {
            padding: 3em 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition-duration: 0.2s;
            border-top: 1px solid var(--color-border);
        }

        .bottom:hover {
            padding: 3em 2em;
            background-color: var(--color-bg-hover);
        }

        .bottom span {
            text-transform: uppercase;
        }
    `];

    render() {
        return html`
            <section class="container">
                <div class="top">
                    <div class="text">
                        <div class="headlines">
                            <h1>Go Native.</h1>
                            <h1>Stay PHP</h1>
                        </div>
                        <p class="description">Turn your PHP project into cross-platform, compact, fast, native
                            applications for Windows, macOS, Linux, Android and iOS.</p>
                        <div class="buttons">
                            <button-primary text="Try Boson for Free" href="/"></button-primary>
                            <button-secondary text="Watch Presentation" href="/"></button-secondary>
                        </div>
                    </div>
                    <img class="img" src="/images/hero.svg" alt="hero"/>
                </div>

                <a href="#nativeness" class="bottom">
                    <span>Discover more about boson</span>
                    <img src="/images/icons/arrow_down.svg" alt="arrow_down"/>
                </a>
            </section>
        `;
    }
}

customElements.define('hero-section', HeroSection);
