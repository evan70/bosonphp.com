import {css, html, LitElement} from 'lit';

import {sharedStyles} from "../../utils/sharedStyles.js";

export class RightChoiceSection extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            background-size: 100% auto;
            background: url("/images/right_choice_bg.png") no-repeat top;
            height: 200vh;
            display: flex;
            flex-direction: column;
        }

        .top {
            margin: 18em;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .red {
            color: var(--color-text-brand);
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            border-top: 1px solid var(--color-border);
        }
        .content-top {
            border-bottom: 1px solid var(--color-border);
        }
        .sep {
            min-width: 1px;
            align-self: stretch;
            background: var(--color-border);
        }
        .content-top, .content-bottom {
            display: flex;
            align-self: stretch;
            flex: 1;
        }
        .content-left, .content-right {
            display: flex;
            position: relative;
            flex: 1;
            padding: 4em;
            overflow: hidden;
        }
        .content-top > div {
            align-items: flex-end;
        }
        .content-left {
            justify-content: flex-end;
            mask-image: linear-gradient(to left, transparent 0%, black 4em);
        }
        .content-right {
            justify-content: flex-start;
            mask-image: linear-gradient(to right, transparent 0%, black 4em);
        }

        .inner {
            width: 55%;
            transition: transform 0.25s ease;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1em;
        }
    `];

    static animationConfig = {
        triggerOffset: -0.8,
        animationDistance: 115,
        speed: 4.5,
    };

    constructor() {
        super();
        this.handleScroll = this.handleScroll.bind(this);
        this.isIntersecting = false;
    }

    firstUpdated() {
        this.observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    this.isIntersecting = entry.isIntersecting;
                    if (this.isIntersecting) {
                        window.addEventListener('scroll', this.handleScroll, { passive: true });
                        this.handleScroll();
                    } else {
                        window.removeEventListener('scroll', this.handleScroll);
                    }
                });
            },
            {
                rootMargin: '50px 0px 50px 0px',
                threshold: 0.1
            }
        );

        this.observer.observe(this);
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this.observer) {
            this.observer.disconnect();
        }
        window.removeEventListener('scroll', this.handleScroll);
    }

    handleScroll() {
        if (!this.isIntersecting) return;

        const rect = this.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const config = RightChoiceSection.animationConfig;

        const triggerPoint = windowHeight * config.triggerOffset;
        const elementTop = rect.top;
        const elementHeight = rect.height;

        let progress = Math.max(0, Math.min(1,
            (triggerPoint - elementTop) / (elementHeight * 0.5)
        )) * config.speed;

        this.animateElements(progress);
    }

    animateElements(progress) {
        const config = RightChoiceSection.animationConfig;
        const maxTranslate = config.animationDistance;

        const topLeft = this.shadowRoot.querySelector('.content-top .content-left .inner');
        const topRight = this.shadowRoot.querySelector('.content-top .content-right .inner');
        const bottomLeft = this.shadowRoot.querySelector('.content-bottom .content-left .inner');
        const bottomRight = this.shadowRoot.querySelector('.content-bottom .content-right .inner');

        if (!topLeft || !topRight || !bottomLeft || !bottomRight) return;

        const topLeftTranslate = progress * maxTranslate;
        topLeft.style.transform = `translateX(${topLeftTranslate}%)`;

        const topRightTranslate = Math.min(0, -maxTranslate + (progress * maxTranslate));
        topRight.style.transform = `translateX(${topRightTranslate}%)`;

        const bottomRightTranslate = -(progress * maxTranslate);
        bottomRight.style.transform = `translateX(${bottomRightTranslate}%)`;

        const bottomLeftTranslate = Math.max(0, maxTranslate - (progress * maxTranslate));
        bottomLeft.style.transform = `translateX(${bottomLeftTranslate}%)`;
    }

    render() {
        return html`
            <section class="container">
                <div class="top">
                    <h1>Why is Boson PHP</br> <span class="red">the right choice</span> </br>for you?</h1>
                </div>
                <div class="content">
                    <div class="content-top">
                        <div class="content-left">
                            <div class="inner">
                                <h3>Your PHP — On All Devices</h3>
                            </div>
                        </div>
                        <div class="sep"></div>
                        <div class="content-right">
                            <div class="inner">
                                <h3>Your PHP — Is meow</h3>
                            </div>
                        </div>
                    </div>
                    <div class="content-bottom">
                        <div class="content-left">
                            <div class="inner">
                                <p>No need PHP, and that's all you need. Write code oncecOS, Linux, Android, and iOd your app is available everywhere.</p>
                                <button-secondary href="/" text="Read More"></button-secondary>
                            </div>
                        </div>
                        <div class="sep"></div>
                        <div class="content-right">
                            <div class="inner">
                                <p>No need to learn other languages! You already know PHP, and that's all you need. Write code once for the Web and create native apps on Windows, macOS, Linux, Android, and iOS. The same code, and your app is available everywhere.</p>
                                <button-primary href="/" text="Read More"></button-primary>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        `;
    }
}

customElements.define('right-choice-section', RightChoiceSection);
