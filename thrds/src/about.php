<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>thrds</title>
        <style>
            /* Reset and base */
            * {
                box-sizing: border-box;
            }
            body {
                margin: 0;
                background: #f9f9f9;
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                color: #222;
                filter: grayscale(100%);
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                padding: 1rem;
            }

            /* Container with subtle shadow and border */
            .container {
                background: #fff;
                border: 1px solid #ccc;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
                border-radius: 8px;
                max-width: 500px;
                padding: 2rem 2.5rem;
                text-align: center;
                animation: fadeIn 1.2s ease forwards;
                opacity: 0;
            }

            /* Header style */
            .container h1 {
                margin: 0 0 1rem 0;
                font-weight: 700;
                font-size: 2rem;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                color: #444;
            }

            /* Paragraph style */
            .container p {
                font-size: 1.15rem;
                line-height: 1.6;
                color: #555;
                margin-bottom: 1.5rem;
            }

            /* Subtle underline effect */
            .underline {
                display: inline-block;
                border-bottom: 2px solid #aaa;
                padding-bottom: 2px;
                margin-bottom: 1.5rem;
            }

            /* Small footer text */
            .footer-text {
                font-size: 0.9rem;
                color: #888;
                font-style: italic;
            }

            /* Fade-in animation */
            @keyframes fadeIn {
                to {
                    opacity: 1;
                }
            }
        </style>
    </head>
    <body>
        <div class="container" role="main" aria-label="Tech stack info">
            <h1 class="underline">thrds</h1>
            <p>
                Tech Stack is <strong>OpenSwoole</strong> (backend) and
                <strong>Vanilla JS</strong> (frontend).
            </p>
            <p class="footer-text"><a href="https://github.com/sowhatnowgithub/thrds">Github</a></p>
        </div>
    </body>
</html>
