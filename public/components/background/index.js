export function initSparkonicsBackground() {
  const style = document.createElement("style");
  style.innerHTML = `
    body {
      background: linear-gradient(135deg, #000818 0%, #001122 50%, #000510 100%);
      min-height: 100vh;
    }

    .sparkonics-ambient-bg {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background:
        radial-gradient(circle at 20% 80%, rgba(0, 240, 255, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 211, 0, 0.1) 0%, transparent 50%);
      z-index: 0;
      pointer-events: none;
      animation: sparkonicsAmbientShift 20s ease-in-out infinite;
    }

    @keyframes sparkonicsAmbientShift {
      0%, 100% {
        background:
          radial-gradient(circle at 20% 80%, rgba(0, 240, 255, 0.15) 0%, transparent 50%),
          radial-gradient(circle at 80% 20%, rgba(255, 211, 0, 0.1) 0%, transparent 50%);
      }
      50% {
        background:
          radial-gradient(circle at 60% 20%, rgba(0, 240, 255, 0.12) 0%, transparent 50%),
          radial-gradient(circle at 30% 70%, rgba(255, 211, 0, 0.08) 0%, transparent 50%);
      }
    }

    .sparkonics-dynamic-waves {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      z-index: 1;
      pointer-events: none;
      overflow: hidden;
    }

    .sparkonics-wave {
      position: absolute;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg,
        transparent 40%,
        rgba(0, 240, 255, 0.02) 50%,
        transparent 60%);
      animation: sparkonicsWaveMove 15s linear infinite;
    }

    .sparkonics-wave:nth-child(1) {
      animation-duration: 20s;
      animation-delay: -5s;
    }

    .sparkonics-wave:nth-child(2) {
      background: linear-gradient(-45deg,
        transparent 40%,
        rgba(255, 211, 0, 0.015) 50%,
        transparent 60%);
      animation-duration: 25s;
      animation-delay: -10s;
    }

    @keyframes sparkonicsWaveMove {
      0% { transform: translate(-50%, -50%) rotate(0deg); }
      100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    .sparkonics-grid-overlay {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background-image:
        linear-gradient(rgba(0, 240, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 240, 255, 0.03) 1px, transparent 1px);
      background-size: 50px 50px;
      z-index: 1;
      pointer-events: none;
    }
  `;
  document.head.appendChild(style);

  const make = (cls, html = "") => {
    const el = document.createElement("div");
    el.className = cls;
    el.innerHTML = html;
    document.body.appendChild(el);
    return el;
  };

  make("sparkonics-ambient-bg");
  make("sparkonics-grid-overlay");
  make(
    "sparkonics-dynamic-waves",
    `
      <div class="sparkonics-wave"></div>
      <div class="sparkonics-wave"></div>
    `,
  );

  // Return cleanup function
  return () => {
    [
      "sparkonics-ambient-bg",
      "sparkonics-grid-overlay",
      "sparkonics-dynamic-waves",
    ].forEach((cls) => {
      const el = document.querySelector(`.${cls}`);
      if (el) el.remove();
    });

    if (style.parentNode) style.parentNode.removeChild(style);
  };
}
