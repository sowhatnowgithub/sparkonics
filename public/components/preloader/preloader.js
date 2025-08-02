/**
 * Atomic Preloader - Standalone Module (with glow, custom atom background)
 * Usage: import { showAtomicPreloader } from './preloader.js'
 */
export function showAtomicPreloader(options = {}) {
  const config = {
    timeout: options.timeout || 5000,
    onComplete: options.onComplete || function () {},
    loadingText: options.loadingText || "Loading...",
    subtitle: options.subtitle || "Please wait",
    showProgress: options.showProgress || false,
    fadeOutDuration: options.fadeOutDuration || 800,
  };

  const style = document.createElement("style");
  style.innerHTML = `
    .atomic-preloader-overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100vw;
      height: 100vh;
      background: transparent;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      opacity: 1;
      transition: opacity ${config.fadeOutDuration}ms ease-out;
      pointer-events: all;
    }

    .atomic-preloader-overlay.fade-out {
      opacity: 0;
      pointer-events: none;
    }

    .atomic-preloader-wrapper {
      position: relative;
      width: 600px;
      height: 600px;
      display: flex;
      justify-content: center;
      align-items: center;
      background: radial-gradient(circle at center, rgba(0, 10, 30, 0.95), rgba(0, 0, 0, 0.7));
      border-radius: 30px;
      box-shadow: 0 0 40px rgba(0, 240, 255, 0.3), 0 0 80px rgba(255, 211, 0, 0.1);
      backdrop-filter: blur(6px);
      z-index: 10000;
    }

    .atomic-loader {
      position: relative;
      width: 300px;
      height: 300px;
      display: flex;
      justify-content: center;
      align-items: center;
      box-shadow: 0 0 60px rgba(0, 255, 255, 0.08), 0 0 30px rgba(0, 240, 255, 0.2);
      border-radius: 50%;
    }

    .nucleus {
      position: absolute;
      width: 55px;
      height: 55px;
      background: radial-gradient(circle, #FFD300 30%, #FFA500 70%, #FF8C00 100%);
      border-radius: 50%;
      animation: nucleusPulse 3s ease-in-out infinite;
      z-index: 20;
      box-shadow: 0 0 25px rgba(255, 200, 0, 0.95), 0 0 90px rgba(255, 170, 0, 0.5), inset 0 0 30px rgba(255, 200, 0, 0.6);
    }

    @keyframes nucleusPulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.15); }
    }

    .orbit {
      position: absolute;
      border-radius: 50%;
      border: 1px solid rgba(255,255,255,0.05);
      box-shadow: 0 0 8px rgba(0, 240, 255, 0.12);
    }

    .orbit-1 { width: 150px; height: 150px; animation: orbit1 6s linear infinite; }
    .orbit-2 { width: 120px; height: 120px; animation: orbit2 4.2s linear infinite reverse; transform: rotateX(65deg) rotateY(15deg); }
    .orbit-3 { width: 200px; height: 200px; animation: orbit3 8s linear infinite; transform: rotateX(-30deg) rotateZ(45deg); }

    @keyframes orbit1 { 100% { transform: rotate(360deg); } }
    @keyframes orbit2 { 100% { transform: rotateX(65deg) rotateY(15deg) rotate(360deg); } }
    @keyframes orbit3 { 100% { transform: rotateX(-30deg) rotateZ(45deg) rotate(360deg); } }

    .particle {
      position: absolute;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      font-size: 12px;
      color: white;
      top: -12px;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
    }

    .proton {
      width: 24px;
      height: 24px;
      background: radial-gradient(circle, #FFD300 30%, #FFA500 70%, #FF8C00 100%);
      left: 60px;
    }
    .proton::before { content: '+'; }

    .electron {
      width: 20px;
      height: 20px;
      background: radial-gradient(circle, #00F0FF 30%, #0080FF 70%, #0060FF 100%);
      left: 50px;
    }
    .electron::before { content: '−'; }
    .electron-2 { width: 18px; height: 18px; left: 100px; }

    .loading-text {
      position: absolute;
      bottom: -40px;
      left: 50%;
      transform: translateX(-50%);
      color: #FFD300;
      font-family: sans-serif;
      font-size: 2.2rem;
      font-weight: 600;
      text-align: center;
      z-index: 25;
      white-space: nowrap;
      text-shadow: 0 0 10px rgba(255, 211, 0, 0.9);
    }

    .loading-subtitle {
      position: absolute;
      bottom: -80px;
      left: 50%;
      transform: translateX(-50%);
      color: rgba(0, 240, 255, 0.85);
      font-family: sans-serif;
      font-size: 0.9rem;
      text-align: center;
      z-index: 25;
      white-space: nowrap;
      text-shadow: 0 0 6px rgba(0, 240, 255, 0.6);
    }

    .progress-bar-container {
      position: absolute;
      bottom: -120px;
      left: 50%;
      transform: translateX(-50%);
      width: 250px;
      height: 6px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 3px;
      overflow: hidden;
      z-index: 25;
      box-shadow: 0 0 8px rgba(0, 240, 255, 0.15);
    }

    .progress-bar {
      height: 100%;
      background: linear-gradient(90deg, #FFD300, #00F0FF);
      border-radius: 3px;
      width: 0%;
      transition: width 0.3s ease;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
    }
  `;
  document.head.appendChild(style);

  const overlay = document.createElement("div");
  overlay.className = "atomic-preloader-overlay";
  overlay.innerHTML = `
    <div class="atomic-preloader-wrapper">
      <div class="atomic-loader">
        <div class="orbit orbit-1"><div class="particle proton"></div></div>
        <div class="orbit orbit-2"><div class="particle electron"></div></div>
        <div class="orbit orbit-3"><div class="particle electron electron-2"></div></div>
        <div class="nucleus"></div>
        <div class="loading-text">${config.loadingText}</div>
        <div class="loading-subtitle">${config.subtitle}</div>
        ${config.showProgress ? `<div class="progress-bar-container"><div class="progress-bar"></div></div>` : ""}
      </div>
    </div>
  `;

  document.body.appendChild(overlay);

  if (config.showProgress) {
    const progressBar = overlay.querySelector(".progress-bar");
    let startTime = Date.now();

    const update = setInterval(() => {
      const elapsed = Date.now() - startTime;
      const progress = Math.min((elapsed / config.timeout) * 100, 100);
      progressBar.style.width = progress + "%";
      if (progress >= 100) clearInterval(update);
    }, 50);
  }

  setTimeout(() => {
    overlay.classList.add("fade-out");
    setTimeout(() => {
      overlay.remove();
      config.onComplete();
    }, config.fadeOutDuration);
  }, config.timeout);
}
