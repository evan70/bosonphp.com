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
        return [
            {
                name: "Aleksei Gagarin",
                pfp: "/images/u/roxblnfk.png",
                role: "RoadRunner, Cycle ORM",
                comment: "Finally, genuine native PHP - exactly as it should be."
            },
            {
                name: "Sergey Panteleev",
                pfp: "/images/u/saundefined.png",
                role: "PHP Release Manager",
                comment: "Every year, PHP and its ecosystem get better, partly" +
                    "thanks to projects that bring something new to PHP.\n" +
                    "I like how fast it is, how user-friendly it is, and its " +
                    "huge potential for cross-platform applications.\n\n" +
                    "I’ll be following the development of Boson."
            },
        ];
    }

    render() {
        return html`
            <section class="container">
                <div class="content">
                    <slider-component .slides=${this.slides}></slider-component>
                </div>
            </section>
        `;
    }
}

customElements.define('testimonials-section', TestimonialsSection);
