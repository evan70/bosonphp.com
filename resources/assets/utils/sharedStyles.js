import { css } from 'lit';

export const sharedStyles = css`
    h1, h2, h3, h4, h5, h6 {
        font-family: var(--font-title);
        color: var(--color-text);
        margin: 0;
        padding: 0;
        line-height: 1.1;
    }
    h1 {
        font-size: clamp(8rem, 1vw + 8rem, 10rem);
    }
    h2 {
        font-size: clamp(3rem, 1vw + 3.5rem, 5rem);
        font-weight: 500;
    }
    h3 {
        font-size: max(2rem, min(2rem + 1vw, 5rem));
        font-weight: 500;
    }
    h4 {
        font-size: max(1.5rem, min(2rem + 1vw, 2.25rem));
        font-weight: 500;
    }
    h5 {
        font-weight: 400;
        font-size: 1.8rem;
    }
    h6 {
        font-weight: 500;
    }

    p {
        font-size: max(1rem, min(0.55rem + 0.55vw, 2rem));
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
    @media (orientation: portrait) {
        h1 {
            font-size: 5rem;
        }
        h2 {
            font-size: clamp(3rem, 1vw + 3.5rem, 5rem);
        }
        h3 {
            font-size: max(2rem, min(2rem + 1vw, 5rem));
        }
        h4 {
            font-size: max(1.5rem, min(2rem + 1vw, 2.25rem));
        }
        h5 {
        }
        h6 {
        }
        p {
            font-size: 1.25rem;
        }
    }
`;
