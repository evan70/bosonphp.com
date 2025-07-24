import {css, html, LitElement} from 'lit';
import './dots-container.js';

export class BosonFooter extends LitElement {
    static styles = [css`
        .container {
            display: flex;
            flex-direction: column;
        }

        .content {
            border-top: 1px solid var(--border-color-1);
            border-bottom: 1px solid var(--border-color-1);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .top {
            display: flex;
            border-bottom: 1px solid var(--border-color-1);
        }

        .bottom {
            display: flex;
        }

        .dots-left, .dots-right {
            min-width: 120px;
            max-width: 120px;
            position: absolute;
            top: 0;
            bottom: 0;
        }

        .dots-left {
            left: 0;
        }

        .dots-right {
            right: 0;
        }

        .holder {
            min-width: 120px;
            max-width: 120px;
        }

        .holder:nth-child(1) {
            border-right: 1px solid var(--border-color-1);
        }

        ::slotted(a) {
            padding: 3.5em 0;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 230px;
            border-right: 1px solid var(--border-color-1);
            transition-duration: 0.2s;
        }

        ::slotted(a:hover) {
            background: var(--bg-1-hover);
        }

        [name="secondary-link"]::slotted(a) {
            color: var(--color-paragraph-1) !important;
        }

        [name="secondary-link"]::slotted(a:hover) {
            background: var(--bg-1-hover) !important;
        }

        .dots-main {
            flex: 1;
            border-right: 1px solid var(--border-color-1);
            padding: 1em;
        }

        .dots-inner {
            height: 100%;
            width: 100%;
            background: url("/images/icons/dots.svg");
            background-size: cover;
        }

        .copyright {
            flex: 1;
            border-right: 1px solid var(--border-color-1);
            display: flex;
            align-items: center;
            margin-left: 3em;
            font-size: max(1rem, min(.55rem + .55vw, 2rem));
            line-height: 1.75;
            color: var(--color-paragraph-1);
        }

        .credits {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 2em;
        }

        .credits img {
            height: 24px;
        }
    `];

    render() {
        return html`
            <footer class="container">
                <div class="content">
                    <div class="top">
                        <div class="holder"></div>

                        <slot name="main-link"></slot>

                        <div class="dots-main">
                            <div class="dots-inner"></div>
                        </div>

                        <slot name="aside-link"></slot>

                        <div class="holder"></div>
                    </div>

                    <div class="bottom">
                        <div class="holder"></div>

                        <div class="copyright">
                            <slot name="copyright"></slot>
                        </div>

                        <slot name="secondary-link"></slot>

                        <div class="holder"></div>
                    </div>

                    <div class="dots-left">
                        <dots-container></dots-container>
                    </div>

                    <div class="dots-right">
                        <dots-container></dots-container>
                    </div>
                </div>
                <div class="credits">
                    <img src="/images/credits.png" alt="credits"/>
                </div>
            </footer>
        `;
    }
}

customElements.define('boson-footer', BosonFooter);
