import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class TestimonialsSection extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 6em;
        }

        .top {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3em;
        }

        .headline {
            text-align: center;
        }

        .container:before {
            content: '';
            position: absolute;
            pointer-events: none;
            background: radial-gradient(50% 50% at 50% 50%, #F93904 0%, #0A0A0A 50%);
            opacity: 0.3;
            inset: 0;
            filter: blur(140px);
            z-index: -1;
        }
    `];

    get slides() {
        return [{
            name: "Alex Bondareev",
            pfp: "img.png",
            role: "Co-founder, Boson PHP",
            comment: "Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."
        }, {
            name: "Alex Bondareev",
            pfp: "img.png",
            role: "Co-founder, Boson PHP",
            comment: "Building irst meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."
        }, {
            name: "Alex Bondareev",
            pfp: "img.png",
            role: "Co-founder, Boson PHP",
            comment: "From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."
        }, {
            name: "Alex Bondareev4",
            pfp: "img.png",
            role: "Co-founder, Boson PHP",
            comment: "Supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."
        }, {
            name: "Alex Bondareev",
            pfp: "img.png",
            role: "Co-founder, Boson PHP",
            comment: "Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."
        }, {
            name: "Alex Bondareev",
            pfp: "img.png",
            role: "Co-founder, Boson PHP",
            comment: "Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."
        }, {
            name: "Alex Bondareev",
            pfp: "img.png",
            role: "Co-founder, Boson PHP",
            comment: "Building the future requires partners who make you feel like you're in it together. From our very first meeting, the Hartmann team has been actively involved, supporting our product development and business strategy and facilitating critical connections. Their deep understanding of gaming and spatial computing made them the ideal partner for us."
        },];
    }

    render() {
        return html`
            <section class="container">
                <div class="top">
                    <subtitle-component name="Testimonials"></subtitle-component>
                    <div class="headline">
                        <h2>Developers that </br>believe in us</h2>
                    </div>
                </div>
                <div class="content">
                    <slider-component .slides=${this.slides}></slider-component>
                </div>
            </section>
        `;
    }
}

customElements.define('testimonials-section', TestimonialsSection);
