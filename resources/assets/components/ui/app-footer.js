import { LitElement, html, css } from 'lit';
import './dots-container.js';
import {sharedStyles} from "../../utils/sharedStyles.js";

export class AppFooter extends LitElement {
    static styles = [
        sharedStyles,
        css`
    .container {
      display: flex;
      flex-direction: column;
    }
    .content {
      border-top: 1px solid var(--border-color-1);
      border-bottom: 1px solid var(--border-color-1);
      display: flex;
      flex-direction: column;
      position: relative;
    }
    .top {
      display: flex;
      border-bottom: 1px solid var(--border-color-1);
    }
    .bottom {
      display: flex;
    }
    .dotsLeft, .dotsRight {
      min-width: 120px;
      max-width: 120px;
      position: absolute;
      top: 0;
      bottom: 0;
    }
    .dotsLeft {
      left: 0;
    }
    .dotsRight {
      right: 0;
    }
    .holder {
      min-width: 120px;
      max-width: 120px;
    }
    .holder:nth-child(1) {
      border-right: 1px solid var(--border-color-1);
    }
    .linkMain, .linkSecondary {
      padding: 3.5em 0;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 230px;
      border-right: 1px solid var(--border-color-1);
      transition-duration: 0.2s;
    }
    .linkMain:hover, .linkSecondary:hover {
      background: var(--bg-1-hover);
    }
    .linkSecondary {
      color: var(--color-paragraph-1);
    }
    .dotsMain {
      flex: 1;
      border-right: 1px solid var(--border-color-1);
      padding: 1em;
    }
    .dotsInner {
      height: 100%;
      width: 100%;
      background: url("/images/icons/dots.svg");
      background-size: cover;
    }
    .copyright {
      flex: 1;
      border-right: 1px solid var(--border-color-1);
      display: flex;
      align-items: center;
      margin-left: 3em;
      font-size: max(1rem, min(.55rem + .55vw, 2rem));
      line-height: 1.75;
    }
    .credits {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 2em;
    }
    .credits img {
      height: 24px;
    }
  `];

    render() {
        return html`
      <footer class="container">
        <div class="content">
          <div class="top">
            <div class="holder"></div>
            <a href="/" class="linkMain">
              <img src="/images/icons/github.svg" alt="github"/>
            </a>
            <a href="/" class="linkMain">
              <img src="/images/icons/discord.svg" alt="discord"/>
            </a>
            <a href="/" class="linkMain">
              <img src="/images/icons/telegram.svg" alt="telegram"/>
            </a>
            <div class="dotsMain">
              <div class="dotsInner"></div>
            </div>
            <a href="/" class="linkMain">
              Get started
            </a>
            <a href="/" class="linkMain">
              Documentation
            </a>
            <div class="holder"></div>
          </div>
          <div class="bottom">
            <div class="holder"></div>
            <div class="copyright">
              <p>BOSON PHP © 2025. All Rights Reversed.</p>
            </div>
            <a href="/" class="linkSecondary">
              Contribution Guide
            </a>
            <a href="/" class="linkSecondary">
              License
            </a>
            <a href="/" class="linkSecondary">
              Terms of use
            </a>
            <div class="holder"></div>
          </div>
          <div class="dotsLeft">
            <dots-container></dots-container>
          </div>
          <div class="dotsRight">
            <dots-container></dots-container>
          </div>
        </div>
        <div class="credits">
          <img src="/images/credits.png" alt="credits"/>
        </div>
      </footer>
    `;
    }
}

customElements.define('app-footer', AppFooter);