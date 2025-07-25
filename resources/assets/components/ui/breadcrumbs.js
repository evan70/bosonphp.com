import {css, html, LitElement} from 'lit';

export class BosonBreadcrumbs extends LitElement {
    static properties = {};

    static styles = [css`
        .breadcrumbs {
            height: 50px;
            line-height: 50px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-content: center;
            border-bottom: 1px solid var(--color-border);
            border-top: 1px solid var(--color-border);
            transition-duration: 0.2s;
            background: var(--color-bg-opacity);
            backdrop-filter: blur(14px);
            z-index: 10;
        }

        .breadcrumbs::before,
        .breadcrumbs::after {
            content: '';
            display: block;
            width: 100px;
            height: 100%;
        }

        .breadcrumbs::before {
            border-right: 1px solid var(--color-border);
        }

        .breadcrumbs::after {
            border-left: 1px solid var(--color-border);
        }

        .breadcrumbs-items {
            display: flex;
            flex-wrap: nowrap;
            align-content: center;
            flex: 1;
        }

        ::slotted(*) {
            display: flex;
            align-items: center;
            height: 100%;
            position: relative;
            padding: 0 30px 0 55px;
            transition: background .2s ease;
        }

        ::slotted(*:first-child) {
            padding-left: 40px;
        }

        ::slotted(*)::before,
        ::slotted(*)::after {
            top: -2px;
            content: '';
            width: 0;
            border-radius: 6px;
            right: -50px;
            position: absolute;
            aspect-ratio: 1 / 1;
            border: solid 27px transparent;
            border-left-color: var(--color-bg);
            z-index: 2;
            transition: border-left-color .2s ease;
        }

        ::slotted(*)::before {
            right: -52px;
            border-radius: 2px;
            border-left-color: var(--color-border);
        }

        ::slotted(*:last-child)::after,
        ::slotted(*:last-child)::before {
          display: none;
        }

        ::slotted(*:not(:last-child):hover) {
            background: var(--color-bg-hover);
        }

        ::slotted(*:not(:last-child):hover)::after {
            border-left-color: var(--color-bg-hover);
        }
    `];

    constructor() {
        super();
    }

    render() {
        return html`
            <nav class="breadcrumbs">
                <div class="breadcrumbs-items">

                    <slot></slot>

                </div>
            </nav>
        `;
    }
}

customElements.define('boson-breadcrumbs', BosonBreadcrumbs);
