import { LitElement, html, css } from 'lit';
import '../ui/subtitle.js';
import '../logic/button-primary.js';
import {sharedStyles} from "../../utils/sharedStyles.js";

export class MobileDevelopmentSection extends LitElement {
    static styles = [
        sharedStyles,
        css`
    .container {
      display: flex;
      justify-content: center;
      position: relative;
      border-top: 1px solid var(--border-color-1);
    }
    .left {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-self: stretch;
      position: relative;
      border-right: 1px solid var(--border-color-1);
      border-bottom: 1px solid var(--border-color-1);
    }
    .wrapper {
      top: 10em;
      position: sticky;
      gap: 3em;
      display: flex;
      padding: 4em 6em;
      flex-direction: column;
      align-items: flex-start;
    }
    .right {
      display: flex;
      flex-direction: column;
      flex: 1;
    }
    .red {
      color: var(--red);
    }
    .description {
      font-size: max(1rem, min(.55vw + .55rem, 2rem));
      line-height: 1.75;
    }
    .headline h1 {
      font-size: max(3rem, min(1vw + 3.5rem, 5rem));
      font-weight: 500;
      line-height: 1.1;
    }
    .element {
      border-bottom: 1px solid var(--border-color-1);
      padding: 4em;
      display: flex;
      flex-direction: column;
      gap: 1.5em;
    }
    .top {
      display: flex;
      align-items: center;
      gap: 1.5em;
    }
    .name {
      font-weight: 500;
    }
    .text {
      font-size: max(1rem, min(.55vw + .55rem, 2rem));
      line-height: 1.75;
    }
  `];

    get elements() {
        return [
            {
                text: 'For many businesses, mobile devices are the main audience segment. Web applications are good. Desktop clients are great. Mobile applications are wonderful.',
                icon: 'rocket',
                headline: 'Reaching new audiences'
            },
            {
                text: 'The same PHP code — but now it works on a mobile device. Budget savings and faster launch.',
                icon: 'clients',
                headline: 'New clients without rewriting code'
            },
            {
                headline: 'Convenient for B2B and B2C',
                icon: 'case',
                text: 'Internal CRM, chat applications, offline utilities, task managers, task trackers, dashboards — you can carry everything in your pocket.'
            },
            {
                headline: 'Without pain and extra stacks',
                icon: 'convenient',
                text: 'One stack. One language. One project. PHP from start to launch in the App Store.'
            }
        ];
    }

    renderElement(element) {
        return html`
      <div class="element">
        <div class="top">
          <img class="icon" src="/images/icons/${element.icon}.svg" alt="${element.headline}" />
          <h2 class="name">${element.headline}</h2>
        </div>
        <p class="text">${element.text}</p>
      </div>
    `;
    }

    render() {
        return html`
      <section class="container">
        <div class="left">
          <div class="wrapper">
            <subtitle-component name="Mobile Development"></subtitle-component>
            <div class="headline">
              <h1>Expand Your</h1>
              <h1>Business Horizons:</h1>
              <h1 class="red">PHP Mobile Apps</h1>
            </div>
            <p class="description">With Boson PHP Mobile, you can run your PHP app on Android and iOS - without learning Swift, Kotlin or React Native.</p>
            <button-primary href="/" text="Read More"></button-primary>
          </div>
        </div>
        <div class="right">
          ${this.elements.map(element => this.renderElement(element))}
        </div>
      </section>
    `;
    }
}

customElements.define('mobile-development-section', MobileDevelopmentSection);