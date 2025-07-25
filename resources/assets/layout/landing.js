import {css, html, LitElement} from 'lit';

export class LandingLayout extends LitElement {
    static styles = [css`
        .landing-layout {
            display: flex;
            flex-direction: column;
            gap: 8em;
        }
    `];

    render() {
        return html`
            <main class="landing-layout">
                <slot></slot>
            </main>
        `;
    }
}

customElements.define('boson-landing-layout', LandingLayout);
