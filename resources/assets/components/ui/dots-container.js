import { LitElement, html, css } from 'lit';
import {sharedStyles} from "../../utils/sharedStyles.js";

export class DotsContainer extends LitElement {
    static styles = [sharedStyles,
        css`
    .container {
      position: relative;
      height: 100%;
      width: 100%;
    }
    .inner {
      inset: 1em;
      position: absolute;
    }
    .inner > div {
      height: 5px;
      width: 5px;
      position: absolute;
      background: url("/images/icons/dot.svg");
    }
    .topLeft {
      top: 0;
      left: 0;
    }
    .topRight {
      top: 0;
      right: 0;
    }
    .bottomLeft {
      bottom: 0;
      left: 0;
    }
    .bottomRight {
      bottom: 0;
      right: 0;
    }
  `];

    render() {
        return html`
      <div class="container">
        <div class="inner">
          <div class="topLeft"></div>
          <div class="topRight"></div>
          <div class="bottomLeft"></div>
          <div class="bottomRight"></div>
        </div>
      </div>
    `;
    }
}

customElements.define('dots-container', DotsContainer);