import {css, html, LitElement} from 'lit';

import '../components/sections/hero-section.js';
import '../components/sections/nativeness-section.js';
import '../components/sections/solves-section.js';
import '../components/sections/how-it-works-section.js';
import '../components/sections/right-choice-section.js';
import '../components/sections/mobile-development-section.js';
import '../components/sections/testimonials-section.js';
import '../components/sections/call-to-action-section.js';

import {sharedStyles} from "../utils/sharedStyles.js";

export class HomePage extends LitElement {
    static styles = [sharedStyles, css`
        .page {
            display: flex;
            flex-direction: column;
            gap: 8em;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
        }
    `];

    render() {
        return html`
            <main class="page">
                <hero-section></hero-section>
                <nativeness-section></nativeness-section>
                <solves-section></solves-section>
                <div class="wrapper">
                    <how-it-works-section></how-it-works-section>
                    <right-choice-section></right-choice-section>
                </div>
                <mobile-development-section></mobile-development-section>
                <testimonials-section></testimonials-section>
                <call-to-action-section></call-to-action-section>
            </main>
        `;
    }
}

customElements.define('home-page', HomePage);
