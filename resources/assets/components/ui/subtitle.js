import {css, html, LitElement} from 'lit';
import {sharedStyles} from "../../utils/sharedStyles.js";

export class Subtitle extends LitElement {
    static properties = {
        name: {type: String}
    };

    static styles = [sharedStyles, css`
        .container {
            display: flex;
            gap: 1em;
            justify-content: center;
            align-items: center;
        }

        .name {
            text-transform: uppercase;
        }
    `];

    constructor() {
        super();
        this.name = '';
    }

    render() {
        return html`
            <div class="container">
                <img class="img" src="/images/icons/subtitle.svg" alt="subtitle"/>
                <span class="name">${this.name}</span>
            </div>
        `;
    }
}

customElements.define('subtitle-component', Subtitle);
