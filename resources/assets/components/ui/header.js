import {css, html, LitElement} from 'lit';

export class BosonHeader extends LitElement {
    static properties = {
        isScrolled: {type: Boolean},
    };

    static styles = [css`
        .container {
            height: 100px;
            line-height: 100px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--color-border);
            transition-duration: 0.2s;
            background: var(--color-bg-opacity);
            backdrop-filter: blur(14px);
            z-index: 10;
        }

        .container.scrolled {
            height: 70px;
            line-height: 70px;
        }

        .header-padding {
            width: 100%;
            height: 100px;
        }

        .dots,
        ::slotted(*) {
            height: 100%;
        }

        .dots:nth-child(1) {
            border-right: 1px solid var(--color-border);
        }

        .nav {
            flex: 1;
            padding: 0 3em;
            display: flex;
            gap: 3em;
            border-right: 1px solid var(--color-border);
            align-self: stretch;
            align-items: center;
        }
    `];

    constructor() {
        super();

        this.isScrolled = false;

        this.handleScroll = this.handleScroll.bind(this);
    }

    connectedCallback() {
        super.connectedCallback();
        window.addEventListener('scroll', this.handleScroll);
        this.handleScroll();
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        window.removeEventListener('scroll', this.handleScroll);
    }

    handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        this.isScrolled = scrollTop > 0;
    }

    render() {
        return html`
            <header class="container ${this.isScrolled ? 'scrolled' : ''}">
                <div class="dots">
                    <dots-container></dots-container>
                </div>

                <slot name="logo"></slot>

                <div class="nav">
                    <slot></slot>
                </div>

                <slot name="aside"></slot>

                <div class="dots">
                    <dots-container></dots-container>
                </div>
            </header>
            <div class="header-padding"></div>
        `;
    }
}

customElements.define('boson-header', BosonHeader);
