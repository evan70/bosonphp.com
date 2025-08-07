import {css, html, LitElement} from 'lit';
import {sharedStyles} from "../../../utils/sharedStyles.js";

export class Logo extends LitElement {
    static styles = [sharedStyles, css`
        .container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circle-wrapper {
            width: 100%;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
            aspect-ratio: 1;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dot-container {
            width: 100%;
            height: 100%;
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .square {
            position: absolute;
            transition: opacity 0.3s ease;
            opacity: 1;
        }

        .square.outer {
            background: #888;
        }

        .square.inner {
            background: #ff4500;
        }

        .square.dimmed {
            opacity: 0.1;
        }

        .square.mouse-controlled {
            transition: opacity 0.1s ease;
        }

        @media (max-aspect-ratio: 1/1) {
            .circle-wrapper {
                width: 100%;
                height: auto;
            }
        }

        @media (min-aspect-ratio: 1/1) {
            .circle-wrapper {
                width: auto;
                height: 100%;
            }
        }
    `];

    constructor() {
        super();
        this.squares = [];
        this.animationIntervals = [];
        this.mouseX = -1000;
        this.mouseY = -1000;
        this.animationFrame = null;

        this.config = {
            outerRadius: 260,
            innerRadius: 60,
            gapBetweenCircles: 5,

            outerLayers: 9,
            innerLayers: 5,

            squareSize: 4,
            squareSpacing: 12,

            outerColor: '#8B8B8B',
            innerColor: '#F93904',

            baseSize: 600,

            mouseRadius: 80
        };

        this.handleMouseMove = this.handleMouseMove.bind(this);
        this.handleMouseLeave = this.handleMouseLeave.bind(this);
        this.updateSquareStates = this.updateSquareStates.bind(this);
    }

    firstUpdated() {
        this.createSquares();
        this.startAnimations();

        this.addEventListener('mousemove', this.handleMouseMove);
        this.addEventListener('mouseleave', this.handleMouseLeave);
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        this.animationIntervals.forEach(interval => clearInterval(interval));

        this.removeEventListener('mousemove', this.handleMouseMove);
        this.removeEventListener('mouseleave', this.handleMouseLeave);

        if (this.animationFrame) {
            cancelAnimationFrame(this.animationFrame);
        }
    }

    handleMouseMove(e) {
        const rect = this.getBoundingClientRect();
        this.mouseX = e.clientX - rect.left;
        this.mouseY = e.clientY - rect.top;

        if (!this.animationFrame) {
            this.animationFrame = requestAnimationFrame(this.updateSquareStates);
        }
    }

    handleMouseLeave() {
        this.mouseX = -1000;
        this.mouseY = -1000;
        this.updateSquareStates();
    }

    updateSquareStates() {
        this.animationFrame = null;

        const container = this.shadowRoot.querySelector('.dot-container');
        if (!container) return;

        const rect = container.getBoundingClientRect();
        const scale = Math.min(rect.width, rect.height) / this.config.baseSize;
        const mouseRadius = this.config.mouseRadius * scale;

        this.squares.forEach((square) => {
            const squareRect = square.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();
            const squareX = squareRect.left - containerRect.left + squareRect.width / 2;
            const squareY = squareRect.top - containerRect.top + squareRect.height / 2;

            const dx = this.mouseX - squareX;
            const dy = this.mouseY - squareY;
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < mouseRadius) {
                square.classList.add('mouse-controlled');
                square.classList.remove('dimmed');

                const normalizedDistance = distance / mouseRadius;

                square.style.opacity = (normalizedDistance * 0.6).toString();

                square.dataset.mouseAffected = 'true';
            } else {
                square.classList.remove('mouse-controlled');

                if (square.dataset.mouseAffected === 'true') {
                    square.style.opacity = '';
                    square.dataset.mouseAffected = 'false';

                    if (square.dataset.wasDimmed === 'true') {
                        square.classList.add('dimmed');
                    }
                }
            }
        });
    }

    createSquares() {
        const container = this.shadowRoot.querySelector('.dot-container');
        if (!container) return;

        const rect = container.getBoundingClientRect();
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const scale = Math.min(rect.width, rect.height) / this.config.baseSize;

        const squareSize = this.config.squareSize * scale;
        const spacing = this.config.squareSpacing * scale;

        const outerRadius = this.config.outerRadius * scale;
        const outerInnerRadius = outerRadius - (this.config.outerLayers - 1) * spacing;

        for (let layer = 0; layer < this.config.outerLayers; layer++) {
            const radius = outerRadius - layer * spacing;
            const circumference = 2 * Math.PI * radius;
            const squaresInLayer = Math.floor(circumference / spacing);

            for (let i = 0; i < squaresInLayer; i++) {
                const angle = (i / squaresInLayer) * Math.PI * 2;
                const x = centerX + Math.cos(angle) * radius;
                const y = centerY + Math.sin(angle) * radius;

                const square = document.createElement('div');
                square.className = 'square outer';
                square.style.left = `${x}px`;
                square.style.top = `${y}px`;
                square.style.width = `${squareSize}px`;
                square.style.height = `${squareSize}px`;
                square.style.transform = 'translate(-50%, -50%)';
                square.dataset.mouseAffected = 'false';
                square.dataset.wasDimmed = 'false';
                container.appendChild(square);
                this.squares.push(square);
            }
        }

        const maxInnerRadius = outerInnerRadius - this.config.gapBetweenCircles * scale;
        const innerRadius = Math.min(this.config.innerRadius * scale, maxInnerRadius);

        for (let layer = 0; layer < this.config.innerLayers; layer++) {
            const radius = innerRadius - layer * spacing;
            if (radius <= 0) break;

            if (radius < spacing) {
                const square = document.createElement('div');
                square.className = 'square inner';
                square.style.left = `${centerX}px`;
                square.style.top = `${centerY}px`;
                square.style.width = `${squareSize}px`;
                square.style.height = `${squareSize}px`;
                square.style.transform = 'translate(-50%, -50%)';
                square.dataset.mouseAffected = 'false';
                square.dataset.wasDimmed = 'false';
                container.appendChild(square);
                this.squares.push(square);
                break;
            }

            const circumference = 2 * Math.PI * radius;
            const squaresInLayer = Math.floor(circumference / spacing);

            for (let i = 0; i < squaresInLayer; i++) {
                const angle = (i / squaresInLayer) * Math.PI * 2;
                const x = centerX + Math.cos(angle) * radius;
                const y = centerY + Math.sin(angle) * radius;

                const square = document.createElement('div');
                square.className = 'square inner';
                square.style.left = `${x}px`;
                square.style.top = `${y}px`;
                square.style.width = `${squareSize}px`;
                square.style.height = `${squareSize}px`;
                square.style.transform = 'translate(-50%, -50%)';
                square.dataset.mouseAffected = 'false';
                square.dataset.wasDimmed = 'false';
                container.appendChild(square);
                this.squares.push(square);
            }
        }
    }

    startAnimations() {
        // Animate random squares
        this.squares.forEach((square) => {
            // Start some squares dimmed
            if (Math.random() > 0.7) {
                square.classList.add('dimmed');
                square.dataset.wasDimmed = 'true';
            }

            const interval = setInterval(() => {
                if (square.dataset.mouseAffected !== 'true') {
                    if (Math.random() > 0.8) {
                        square.classList.toggle('dimmed');
                        square.dataset.wasDimmed = square.classList.contains('dimmed') ? 'true' : 'false';
                    }
                }
            }, 1000 + Math.random() * 2000);

            this.animationIntervals.push(interval);
        });
    }

    render() {
        return html`
            <div class="container">
                <div class="circle-wrapper">
                    <div class="dot-container"></div>
                </div>
            </div>
        `;
    }
}

customElements.define('logo-animated-opacity-component', Logo);
