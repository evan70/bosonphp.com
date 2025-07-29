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
            width: 620px;
            transition: transform 0.5s ease;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1em;
        }
        .progress {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            padding: 3em;
            align-self: stretch;
            border-top: 1px solid var(--color-border);
            gap: 1em;
        }
        .el {
            display: flex;
            flex-direction: row;
            gap: 5px;
        }
        .dots {
            height: 14px;
            width: 5px;
        }
        .dots.red {
            background-image: url("/images/icons/dots_red.svg");
        }
        .dots.grey {
            background-image: url("/images/icons/dots_grey.svg");
        }
        .progress-text {
            text-transform: uppercase;
            color: var(--color-text-secondary);
        }
    `];

    static animationConfig = {
        blockDuration: 3000,
        transitionDuration: 500,
        animationDistance: 800,
    };

    constructor() {
        super();

        this.animationState = {
            currentStage: 0,
            progressDirection: 1,
            startTime: 0,
            animationId: null
        };

        this.elements = {
            topLeft: null,
            topRight: null,
            bottomLeft: null,
            bottomRight: null,
            progressDots: null
        };
    }

    firstUpdated() {
        this.elements.topLeft = this.shadowRoot.querySelector('.content-top .content-left .inner');
        this.elements.topRight = this.shadowRoot.querySelector('.content-top .content-right .inner');
        this.elements.bottomLeft = this.shadowRoot.querySelector('.content-bottom .content-left .inner');
        this.elements.bottomRight = this.shadowRoot.querySelector('.content-bottom .content-right .inner');
        this.elements.progressDots = this.shadowRoot.querySelectorAll('.dots');

        this.startAnimation();
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        this.stopAnimation();
    }

    startAnimation() {
        this.animationState.startTime = Date.now();
        this.animate();
    }

    stopAnimation() {
        if (this.animationState.animationId) {
            cancelAnimationFrame(this.animationState.animationId);
            this.animationState.animationId = null;
        }
    }

    animate() {
        const config = RightChoiceSection.animationConfig;
        const currentTime = Date.now();
        const elapsed = currentTime - this.animationState.startTime;

        const totalCycleDuration = (config.blockDuration * 4) + (config.transitionDuration * 4);
        const cyclePosition = elapsed % totalCycleDuration;

        const phase1End = config.blockDuration;
        const phase2End = phase1End + config.transitionDuration;
        const phase3End = phase2End + config.blockDuration;
        const phase4End = phase3End + config.transitionDuration;
        const phase5End = phase4End + config.blockDuration;
        const phase6End = phase5End + config.transitionDuration;
        const phase7End = phase6End + config.blockDuration;
        const phase8End = phase7End + config.transitionDuration;

        let progressValue = 0;
        let elementStage = 0;

        if (cyclePosition < phase1End) {
            const phaseProgress = cyclePosition / config.blockDuration;
            progressValue = phaseProgress * 0.5;
            elementStage = 0;
        } else if (cyclePosition < phase2End) {
            const transitionElapsed = cyclePosition - phase1End;
            const transitionProgress = transitionElapsed / config.transitionDuration;
            progressValue = 0.5;
            elementStage = transitionProgress;
        } else if (cyclePosition < phase3End) {
            const phaseProgress = (cyclePosition - phase2End) / config.blockDuration;
            progressValue = 0.5 + (phaseProgress * 0.5);
            elementStage = 1;
        } else if (cyclePosition < phase4End) {
            const transitionElapsed = cyclePosition - phase3End;
            const transitionProgress = transitionElapsed / config.transitionDuration;
            progressValue = 1.0;
            elementStage = 1 - transitionProgress;
        } else if (cyclePosition < phase5End) {
            const phaseProgress = (cyclePosition - phase4End) / config.blockDuration;
            progressValue = 1.0 - (phaseProgress * 0.5);
            elementStage = 0;
        } else if (cyclePosition < phase6End) {
            const transitionElapsed = cyclePosition - phase5End;
            const transitionProgress = transitionElapsed / config.transitionDuration;
            progressValue = 0.5;
            elementStage = transitionProgress;
        } else if (cyclePosition < phase7End) {
            const phaseProgress = (cyclePosition - phase6End) / config.blockDuration;
            progressValue = 0.5 - (phaseProgress * 0.5);
            elementStage = 1;
        } else {
            const transitionElapsed = cyclePosition - phase7End;
            const transitionProgress = transitionElapsed / config.transitionDuration;
            progressValue = 0;
            elementStage = 1 - transitionProgress;
        }

        this.animateElements(elementStage);
        this.updateProgressBar(progressValue);

        this.animationState.animationId = requestAnimationFrame(() => this.animate());
    }

    animateElements(progress) {
        const config = RightChoiceSection.animationConfig;
        const maxTranslate = config.animationDistance;

        if (!this.elements.topLeft || !this.elements.topRight ||
            !this.elements.bottomLeft || !this.elements.bottomRight) {
            return;
        }

        const topLeftTranslate = progress * maxTranslate;
        const topRightTranslate = Math.min(0, -maxTranslate + (progress * maxTranslate));
        const bottomRightTranslate = -(progress * maxTranslate);
        const bottomLeftTranslate = Math.max(0, maxTranslate - (progress * maxTranslate));

        this.elements.topLeft.style.transform = `translateX(${topLeftTranslate}px)`;
        this.elements.topRight.style.transform = `translateX(${topRightTranslate}px)`;
        this.elements.bottomRight.style.transform = `translateX(${bottomRightTranslate}px)`;
        this.elements.bottomLeft.style.transform = `translateX(${bottomLeftTranslate}px)`;
    }

    updateProgressBar(progressValue) {
        if (!this.elements.progressDots || this.elements.progressDots.length === 0) {
            return;
        }

        const totalDots = this.elements.progressDots.length; // Should be 30
        const activeDots = Math.floor(progressValue * totalDots);

        this.elements.progressDots.forEach((dot, index) => {
            if (index < activeDots) {
                dot.classList.remove('grey');
                dot.classList.add('red');
            } else {
                dot.classList.remove('red');
                dot.classList.add('grey');
            }
        });
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
                <div class="progress">
                    <div class="el">
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                    </div>
                    <span class="progress-text">STAGE</span>
                    <div class="el">
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                        <div class="dots grey"></div>
                    </div>
                </div>
            </section>
        `;
    }
}

customElements.define('right-choice-section', RightChoiceSection);
