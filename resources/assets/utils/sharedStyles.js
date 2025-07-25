import { css } from 'lit';

export const sharedStyles = css`
    h1, h2, h3, h4, h5, h6 {
        font-family: var(--font-title);
        color: var(--color-text);
        margin: 0;
        padding: 0;
    }

    p {
        color: var(--color-text-secondary);
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
