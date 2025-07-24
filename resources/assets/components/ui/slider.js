import {css, html, LitElement} from 'lit';
import './dots-container.js';
import {sharedStyles} from "../../utils/sharedStyles.js";

export class Slider extends LitElement {
    static properties = {
        slides: {type: Array},
        currentIndex: {type: Number},
        slidesPerView: {type: Number},
    };

    static styles = [sharedStyles, css`
        .container {
            display: flex;
            max-width: 100vw;
            overflow: hidden;
            border-top: 1px solid var(--border-color-1);
            border-bottom: 1px solid var(--border-color-1);
            background: var(--bg-1);
        }

        .sliderContent {
            width: calc(100vw - 240px - 12px);
            overflow: hidden;
        }

        .sliderButton {
            all: unset;
            min-width: 120px;
            max-width: 120px;
            cursor: pointer;
            position: relative;
            transition-duration: 0.2s;
            display: flex;
            flex-direction: column;
            text-transform: uppercase;
            gap: 0.5em;
            justify-content: center;
            align-items: center;
        }

        .sliderButton:hover {
            background-color: var(--bg-1-hover);
        }

        .sliderButton:nth-child(1) {
            border-right: 1px solid var(--border-color-1);
        }

        .sliderButton:nth-last-child(1) {
            border-left: 1px solid var(--border-color-1);
        }

        .dots {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .slidesWrapper {
            display: flex;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .slideWrapper {
            flex: none;
            cursor: grab;
        }

        .slide {
            padding: 3em;
            border-right: 1px solid var(--border-color-1);
            display: flex;
            flex-direction: column;
            gap: 2em;
            height: 100%;
            min-height: 400px;
        }

        .quote {
            align-self: flex-start;
        }

        .comment {
            font-size: max(1rem, min(0.55rem + 0.55vw, 2rem));
            line-height: 1.75;
        }

        .bottom {
            margin-top: auto;
            display: flex;
            gap: 1em;
        }

        .pfp {
            height: 52px;
            width: 52px;
        }

        .info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 0.25em;
        }

        .name {
            font-weight: 500;
        }

        .role {
            color: var(--red);
            text-transform: uppercase;
        }

        @media (min-width: 768px) {
            .slideWrapper {
                width: calc(100% / 3);
            }
        }

        @media (max-width: 767px) {
            .slideWrapper {
                width: 100%;
            }
        }
    `];

    constructor() {
        super();
        this.slides = [];
        this.currentIndex = 0;
        this.slidesPerView = 1;
        this.autoplayInterval = null;
    }

    connectedCallback() {
        super.connectedCallback();
        this.updateSlidesPerView();
        this.startAutoplay();
        window.addEventListener('resize', this.updateSlidesPerView.bind(this));
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        this.stopAutoplay();
        window.removeEventListener('resize', this.updateSlidesPerView.bind(this));
    }

    updateSlidesPerView() {
        this.slidesPerView = window.innerWidth >= 768 ? 3 : 1;
        this.requestUpdate();
    }

    startAutoplay() {
        this.stopAutoplay();
        this.autoplayInterval = setInterval(() => {
            this.slideNext();
        }, 3000);
    }

    stopAutoplay() {
        if (this.autoplayInterval) {
            clearInterval(this.autoplayInterval);
            this.autoplayInterval = null;
        }
    }

    slidePrev() {
        this.currentIndex = this.currentIndex <= 0 ? this.slides.length - this.slidesPerView : this.currentIndex - 1;
        this.requestUpdate();
    }

    slideNext() {
        this.currentIndex = this.currentIndex >= this.slides.length - this.slidesPerView ? 0 : this.currentIndex + 1;
        this.requestUpdate();
    }

    getTransform() {
        const slideWidth = 100 / this.slidesPerView;
        return `translateX(-${this.currentIndex * slideWidth}%)`;
    }

    renderSlide(slide, index) {
        return html`
            <div class="slideWrapper">
                <div class="slide">
                    <img class="quote" src="/images/icons/quote.svg" alt="quote"/>
                    <p class="comment">"${slide.comment}"</p>
                    <div class="bottom">
                        <img class="pfp" src="/images/${slide.pfp}" alt="${slide.name}"/>
                        <div class="info">
                            <h3 class="name">${slide.name}</h3>
                            <p class="role">${slide.role}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    render() {
        return html`
            <div class="container">
                <button class="sliderButton" @click=${this.slidePrev}>
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                    <img src="/images/icons/red_arrow_left.svg" alt="prev"/>
                    <span>Prev</span>
                </button>
                <div class="sliderContent">
                    <div class="slidesWrapper" style="transform: ${this.getTransform()}">
                        ${this.slides.map((slide, index) => this.renderSlide(slide, index))}
                    </div>
                </div>
                <button class="sliderButton" @click=${this.slideNext}>
                    <div class="dots">
                        <dots-container></dots-container>
                    </div>
                    <img src="/images/icons/red_arrow_right.svg" alt="next"/>
                    <span>Next</span>
                </button>
            </div>
        `;
    }
}

customElements.define('slider-component', Slider);
