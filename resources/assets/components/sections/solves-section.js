import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class SolvesSection extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            display: flex;
            flex-direction: column;
            gap: 4em;
        }

        .top {
            display: flex;
            justify-content: space-between;
            width: var(--width-content);
            margin: 0 auto;
        }

        .left {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 2em;
        }

        .text h1 {
            font-size: max(3rem, min(1vw + 3.5rem, 5rem));
            font-weight: 500;
            line-height: 1.1;
        }

        .red {
            color: var(--color-text-brand);
        }

        .right {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            max-width: clamp(650px, 40vw, 800px);
            gap: 1em;
        }

        .el {
            display: flex;
            gap: 1em;
            align-items: flex-start;
        }

        .el p {
            transform: translateY(-6px);
            font-size: max(1rem, min(.55vw + .55rem, 2rem));
            line-height: 1.75;
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
            flex: 1;
        }

        .solves {
            border-right: 1px solid var(--color-border);
            padding: 4em;
            gap: 1.25em;
            display: flex;
            line-height: 1.75;
            flex-direction: column;
        }

        .solves img {
            align-self: flex-start;
        }

        .solves h2 {
            font-weight: 500;
        }
    `];

    render() {
        return html`
            <section class="container">
                <div class="top">
                    <div class="left">
                        <subtitle-component name="Solves"></subtitle-component>
                        <div class="text">
                            <h1>What <span class="red">you can</span> do</h1>
                            <h1>with Boson?</h1>
                        </div>
                    </div>
                    <div class="right">
                        <div class="el">
                            <img src="/images/icons/check.svg" alt="check"/>
                            <p>Compile an application for the desired desktop platform based on an existing PHP
                                project.</p>
                        </div>
                        <div class="el">
                            <img src="/images/icons/check.svg" alt="check"/>
                            <p>Create a mobile app. Expand your business and reach a new target audience.</p>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                    <div class="inner">
                        <div class="solves">
                            <img src="/images/icons/terminal.svg" alt="terminal"/>
                            <h2>For developers</h2>
                            <p>Pride in your favorite language, which is not dying! A real desire to create something
                                useful and interesting. Boson will allow you to create applications from scratch, as a
                                framework.</p>
                        </div>
                        <div class="solves">
                            <img src="/images/icons/lock.svg" alt="lock"/>
                            <h2>For business</h2>
                            <p>Desktop application – getting different variants of working applications. Mobile
                                application – expand profits by getting a new segment of the mobile application
                                market.</p>
                        </div>
                        <div class="solves">
                            <img src="/images/icons/web.svg" alt="web"/>
                            <h2>For web studios</h2>
                            <p>No need to expand your staff to make applications for different platforms, work with
                                Bosob and increase your income.</p>
                        </div>
                    </div>
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                </div>
            </section>
        `;
    }
}

customElements.define('solves-section', SolvesSection);
