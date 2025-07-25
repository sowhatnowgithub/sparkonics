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

    .sparkonics-energy-lines {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      z-index: 1;
      pointer-events: none;
    }

    .sparkonics-energy-line {
      position: absolute;
      height: 1px;
      background: linear-gradient(90deg,
        transparent,
        rgba(0, 240, 255, 0.4),
        transparent);
      animation: sparkonicsEnergyFlow 8s linear infinite;
    }

    @keyframes sparkonicsEnergyFlow {
      0% { left: -100%; width: 100px; opacity: 0; }
      10% { opacity: 1; }
      90% { opacity: 1; }
      100% { left: 100%; width: 100px; opacity: 0; }
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

    .sparkonics-particle {
      position: absolute;
      border-radius: 50%;
      animation: sparkonicsFloat 6s infinite ease-in-out;
      opacity: 0.8;
      transition: all 0.3s ease;
      z-index: 1;
    }
    .sparkonics-electron {
      background: #00F0FF;
      width: 6px; height: 6px;
      box-shadow: 0 0 10px #00F0FF;
    }
    .sparkonics-proton {
      background: #FFD300;
      width: 6px; height: 6px;
      box-shadow: 0 0 12px #FFD300;
    }

    @keyframes sparkonicsFloat {
      0%, 100% { transform: translate(0, 0) rotate(0deg); }
      25% { transform: translate(60px, -40px) rotate(90deg); }
      50% { transform: translate(-40px, -80px) rotate(180deg); }
      75% { transform: translate(-80px, 40px) rotate(270deg); }
    }

    .sparkonics-collision-effect {
      position: absolute;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.9) 0%, rgba(0, 240, 255, 0.4) 50%, transparent 100%);
      animation: sparkonicsCollisionBurst 0.8s ease-out forwards;
      pointer-events: none;
      z-index: 2;
    }

    @keyframes sparkonicsCollisionBurst {
      0% { transform: scale(0); opacity: 1; box-shadow: 0 0 0px rgba(255, 255, 255, 0.8); }
      50% { transform: scale(1.5); opacity: 0.8; box-shadow: 0 0 25px rgba(0, 240, 255, 0.6), 0 0 50px rgba(255, 211, 0, 0.3); }
      100% { transform: scale(2.5); opacity: 0; box-shadow: 0 0 60px rgba(0, 240, 255, 0.2); }
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

  const energyLines = make("sparkonics-energy-lines");

  const spawnEnergyLine = () => {
    const line = document.createElement("div");
    line.className = "sparkonics-energy-line";
    line.style.cssText = `
      top: ${Math.random() * 100}vh;
      animation-delay: ${Math.random() * 2}s;
    `;
    energyLines.appendChild(line);
    setTimeout(() => line.remove(), 8000);
  };
  setInterval(spawnEnergyLine, 3000);

  const particles = [];

  const createCollisionEffect = (x, y) => {
    const el = document.createElement("div");
    el.className = "sparkonics-collision-effect";
    el.style.left = `${x}px`;
    el.style.top = `${y}px`;
    document.body.appendChild(el);
    setTimeout(() => el.remove(), 800);
  };

  const spawnParticles = () => {
    for (let i = 0; i < 20; i++) {
      const isElectron = Math.random() > 0.4;
      const el = document.createElement("div");
      el.className = `sparkonics-particle ${isElectron ? "sparkonics-electron" : "sparkonics-proton"}`;

      const x = Math.random() * window.innerWidth;
      const y = Math.random() * window.innerHeight;

      el.style.top = `${y}px`;
      el.style.left = `${x}px`;
      el.style.animationDelay = `${Math.random() * 6}s`;

      const particleData = {
        type: isElectron ? "electron" : "proton",
        x,
        y,
        element: el,
      };

      particles.push(particleData);
      document.body.appendChild(el);

      // Remove particle after some time
      setTimeout(
        () => {
          el.remove();
          const index = particles.indexOf(particleData);
          if (index > -1) particles.splice(index, 1);
        },
        6000 + Math.random() * 3000,
      );
    }
  };

  const checkCollisions = () => {
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const p1 = particles[i];
        const p2 = particles[j];

        if (!p1.element || !p2.element) continue;

        // Only collide if types are different
        if (p1.type !== p2.type) {
          const rect1 = p1.element.getBoundingClientRect();
          const rect2 = p2.element.getBoundingClientRect();

          const distance = Math.hypot(
            rect1.left - rect2.left,
            rect1.top - rect2.top,
          );

          if (distance < 20) {
            // slightly larger threshold for bigger dots
            createCollisionEffect(
              (rect1.left + rect2.left) / 2,
              (rect1.top + rect2.top) / 2,
            );

            // Remove collided particles
            p1.element.remove();
            p2.element.remove();
            particles.splice(j, 1);
            particles.splice(i, 1);
            break;
          }
        }
      }
    }
  };

  spawnParticles();
  setInterval(spawnParticles, 8000);
  setInterval(checkCollisions, 100);

  // Return cleanup function
  return () => {
    [
      "sparkonics-ambient-bg",
      "sparkonics-grid-overlay",
      "sparkonics-dynamic-waves",
      "sparkonics-energy-lines",
    ].forEach((cls) => {
      const el = document.querySelector(`.${cls}`);
      if (el) el.remove();
    });

    particles.forEach((p) => {
      if (p.element) p.element.remove();
    });

    if (style.parentNode) style.parentNode.removeChild(style);
  };
}
