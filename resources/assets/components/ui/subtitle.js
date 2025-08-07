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

    `];

    constructor() {
        super();
        this.name = '';
    }

    render() {
        return html`
            <div class="container">
                <img class="img" src="/images/icons/subtitle.svg" alt="subtitle"/>
                <h6 class="name">${this.name}</h6>
            </div>
        `;
    }
}

customElements.define('subtitle-component', Subtitle);
