import { css } from 'lit';

export const sharedStyles = css`
  h1, h2, h3, h4, h5, h6 {
    font-family: var(--font-poppins);
    color: var(--color-headline-1);
    margin: 0;
    padding: 0;
  }

  p {
    color: var(--color-paragraph-1);
    margin: 0;
    padding: 0;
  }

  a {
    color: inherit;
    text-decoration: none;
  }

  * {
    box-sizing: border-box;
  }
`;
