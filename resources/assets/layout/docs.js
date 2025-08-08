import {css, html, LitElement} from 'lit';

export class DocsLayout extends LitElement {
    static styles = [css`
        .docs-layout {
            display: grid;
            margin: 0 auto;
            width: var(--width-content);
            max-width: var(--width-max);
            grid-template-columns: 1fr 3fr;
        }

        .docs-navigation {
            width: 300px;
            max-width: 300px;
            border-right: solid 1px var(--color-border);
        }

        .docs-navigation-content {
            top: 70px;
            display: flex;
            flex-direction: column;
            position: sticky;
        }

        .docs-navigation-pages,
        .docs-navigation-categories {
            padding: 2em 0;
            display: flex;
            flex-direction: column;
            gap: .5em;
            position: relative;
        }

        ::slotted(strong),
        ::slotted(a) {
            padding: .3em .5em;
        }

        [name="menu"]::slotted(strong) {
            background: var(--color-bg-button);
            color: var(--color-text);
            font-weight: unset;
        }

        .docs-navigation-pages {
            margin-top: -1px;
            border-top: solid 1px var(--color-border);
            background: var(--color-bg-layer);
        }

        .docs-navigation-pages::before {
            content: '';
            width: 100vw;
            height: 100%;
            user-select: none;
            position: absolute;
            background: var(--color-bg-layer);
            border-top: solid 1px var(--color-border);
            border-bottom: solid 1px var(--color-border);
            bottom: -1px;
            right: 300px;
        }

        .docs-navigation-categories {
            position: relative;
            border-top: solid 1px var(--color-border);
            font-size: var(--font-size-secondary);
        }

        .docs-content {
            padding: 2em;
            overflow: auto;
        }

        [name="category"]::slotted(strong) {
            color: var(--color-text-brand);
        }
    `];

    render() {
        return html`
            <main class="docs-layout">
                <aside class="docs-navigation">
                    <div class="docs-navigation-content">
                        <nav class="docs-navigation-pages">
                            <slot name="menu"></slot>
                        </nav>

                        <nav class="docs-navigation-categories">
                            <slot name="category"></slot>
                        </nav>
                    </div>
                </aside>

                <section class="docs-content">
                    <slot></slot>
                </section>
            </main>
        `;
    }
}

customElements.define('boson-docs-layout', DocsLayout);
