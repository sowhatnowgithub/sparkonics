/**
 * Enhanced Atomic Preloader with Full Screen Support and Timeout
 * Usage: renderAtomicPreloader(containerId, options)
 */
export function renderAtomicPreloader(containerId, options = {}) {
  const container = document.getElementById(containerId);
  if (!container) return console.error("Container not found: ", containerId);

  // Default configuration
  const config = {
    timeout: options.timeout || 5000, // 5 seconds default
    onComplete: options.onComplete || (() => {}),
    onTimeout: options.onTimeout || (() => {}),
    fullScreen: options.fullScreen !== false, // true by default
    autoHide: options.autoHide !== false, // true by default
    loadingText: options.loadingText || "Initializing Sparkonics",
    subtitle: options.subtitle || "Loading opportunities...",
    showProgress: options.showProgress || false,
    fadeOutDuration: options.fadeOutDuration || 800,
  };

  // Create and inject styles
  const style = document.createElement("style");
  style.id = "atomic-preloader-styles";
  style.innerHTML = `
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap');

    .atomic-preloader-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: linear-gradient(135deg, #000818 0%, #001122 50%, #000510 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      opacity: 1;
      transition: opacity ${config.fadeOutDuration}ms ease-out;
    }

    .atomic-preloader-overlay.fade-out {
      opacity: 0;
      pointer-events: none;
    }

    .atomic-preloader-wrapper {
      position: relative;
      width: ${config.fullScreen ? "600px" : "100%"};
      height: ${config.fullScreen ? "600px" : "100%"};
      max-width: 600px;
      max-height: 600px;
      display: flex;
      justify-content: center;
      align-items: center;
      background: ${config.fullScreen ? "linear-gradient(135deg, #000818 0%, #001122 50%, #000510 100%)" : "transparent"};
      border-radius: ${config.fullScreen ? "20px" : "0"};
      overflow: visible;
    }

    .preloader-ambient-bg {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background:
        radial-gradient(circle at 30% 70%, rgba(0, 240, 255, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 70% 30%, rgba(255, 211, 0, 0.1) 0%, transparent 50%);
      animation: preloaderAmbientShift 15s ease-in-out infinite;
      border-radius: ${config.fullScreen ? "20px" : "0"};
    }

    @keyframes preloaderAmbientShift {
      0%, 100% {
        background:
          radial-gradient(circle at 30% 70%, rgba(0, 240, 255, 0.15) 0%, transparent 50%),
          radial-gradient(circle at 70% 30%, rgba(255, 211, 0, 0.1) 0%, transparent 50%);
      }
      50% {
        background:
          radial-gradient(circle at 60% 20%, rgba(0, 240, 255, 0.12) 0%, transparent 50%),
          radial-gradient(circle at 40% 80%, rgba(255, 211, 0, 0.08) 0%, transparent 50%);
      }
    }

    .preloader-grid-overlay {
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background-image:
        linear-gradient(rgba(0, 240, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 240, 255, 0.03) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
      border-radius: ${config.fullScreen ? "20px" : "0"};
    }

    .atomic-loader {
      position: relative;
      width: 400px;
      height: 400px;
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 10;
    }

    .nucleus {
      position: absolute;
      width: 45px;
      height: 45px;
      background: radial-gradient(circle, #FFD300 30%, #FFA500 70%, #FF8C00 100%);
      border-radius: 50%;
      box-shadow:
        0 0 25px rgba(255, 211, 0, 0.8),
        0 0 45px rgba(255, 211, 0, 0.6),
        0 0 65px rgba(255, 211, 0, 0.4),
        inset 0 0 12px rgba(255, 255, 255, 0.3);
      animation: nucleusPulse 3s ease-in-out infinite;
      z-index: 20;
    }

    @keyframes nucleusPulse {
      0%, 100% {
        transform: scale(1);
        box-shadow:
          0 0 25px rgba(255, 211, 0, 0.8),
          0 0 45px rgba(255, 211, 0, 0.6),
          0 0 65px rgba(255, 211, 0, 0.4),
          inset 0 0 12px rgba(255, 255, 255, 0.3);
      }
      50% {
        transform: scale(1.15);
        box-shadow:
          0 0 35px rgba(255, 211, 0, 0.9),
          0 0 55px rgba(255, 211, 0, 0.7),
          0 0 80px rgba(255, 211, 0, 0.5),
          inset 0 0 18px rgba(255, 255, 255, 0.4);
      }
    }

    .orbit {
      position: absolute;
      border-radius: 50%;
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .orbit-1 {
      width: 200px;
      height: 200px;
      animation: orbit1Rotate 6s linear infinite;
    }

    .orbit-2 {
      width: 160px;
      height: 160px;
      animation: orbit2Rotate 4.2s linear infinite reverse;
      transform: rotateX(65deg) rotateY(15deg);
    }

    .orbit-3 {
      width: 260px;
      height: 260px;
      animation: orbit3Rotate 8s linear infinite;
      transform: rotateX(-30deg) rotateZ(45deg);
    }

    @keyframes orbit1Rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    @keyframes orbit2Rotate {
      from { transform: rotateX(65deg) rotateY(15deg) rotate(0deg); }
      to { transform: rotateX(65deg) rotateY(15deg) rotate(360deg); }
    }

    @keyframes orbit3Rotate {
      from { transform: rotateX(-30deg) rotateZ(45deg) rotate(0deg); }
      to { transform: rotateX(-30deg) rotateZ(45deg) rotate(360deg); }
    }

    .particle {
      position: absolute;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      font-size: 12px;
      color: white;
      text-shadow: 0 0 8px currentColor;
      top: -12px;
    }

    .proton {
      width: 24px;
      height: 24px;
      background: radial-gradient(circle, #FFD300 30%, #FFA500 70%, #FF8C00 100%);
      box-shadow:
        0 0 18px rgba(255, 211, 0, 0.9),
        0 0 28px rgba(255, 211, 0, 0.6),
        inset 0 0 8px rgba(255, 255, 255, 0.3);
      left: 88px;
    }

    .proton::before {
      content: '+';
      font-size: 14px;
      font-weight: 700;
    }

    .electron {
      width: 20px;
      height: 20px;
      background: radial-gradient(circle, #00F0FF 30%, #0080FF 70%, #0060FF 100%);
      box-shadow:
        0 0 15px rgba(0, 240, 255, 0.9),
        0 0 25px rgba(0, 240, 255, 0.6),
        inset 0 0 6px rgba(255, 255, 255, 0.3);
      left: 70px;
    }

    .electron::before {
      content: '−';
      font-size: 16px;
      font-weight: 700;
    }

    .electron-2 {
      width: 18px;
      height: 18px;
      left: 121px;
    }

    .electron-2::before {
      font-size: 14px;
    }

    .energy-field {
      position: absolute;
      width: 350px;
      height: 350px;
      border-radius: 50%;
      background: radial-gradient(
        circle,
        transparent 30%,
        rgba(255, 211, 0, 0.03) 45%,
        rgba(0, 240, 255, 0.03) 60%,
        transparent 80%
      );
      animation: energyFieldPulse 8s ease-in-out infinite;
    }

    @keyframes energyFieldPulse {
      0%, 100% {
        transform: scale(1);
        opacity: 0.4;
      }
      25% {
        transform: scale(1.08);
        opacity: 0.6;
      }
      50% {
        transform: scale(0.92);
        opacity: 0.5;
      }
      75% {
        transform: scale(1.12);
        opacity: 0.7;
      }
    }

    .particle-trail {
      position: absolute;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      opacity: 0.4;
    }

    .proton-trail {
      background: conic-gradient(from 0deg, transparent 300deg, rgba(255, 211, 0, 0.4) 360deg);
      animation: trailRotate1 6s linear infinite;
    }

    .electron-trail-1 {
      background: conic-gradient(from 180deg, transparent 300deg, rgba(0, 240, 255, 0.4) 360deg);
      animation: trailRotate2 4.2s linear infinite reverse;
    }

    .electron-trail-2 {
      background: conic-gradient(from 90deg, transparent 300deg, rgba(0, 240, 255, 0.3) 360deg);
      animation: trailRotate3 8s linear infinite;
    }

    @keyframes trailRotate1 {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    @keyframes trailRotate2 {
      from { transform: rotateX(65deg) rotateY(15deg) rotate(0deg); }
      to { transform: rotateX(65deg) rotateY(15deg) rotate(360deg); }
    }

    @keyframes trailRotate3 {
      from { transform: rotateX(-30deg) rotateZ(45deg) rotate(0deg); }
      to { transform: rotateX(-30deg) rotateZ(45deg) rotate(360deg); }
    }

    .collision-spark {
      position: absolute;
      width: 8px;
      height: 8px;
      background: radial-gradient(circle, #FFFFFF 0%, #FFD300 50%, transparent 100%);
      border-radius: 50%;
      animation: sparkBurst 1.2s ease-out forwards;
      pointer-events: none;
      z-index: 15;
    }

    @keyframes sparkBurst {
      0% {
        transform: scale(0);
        opacity: 1;
        box-shadow: 0 0 0px rgba(255, 211, 0, 1);
      }
      50% {
        transform: scale(3);
        opacity: 0.9;
        box-shadow: 0 0 30px rgba(255, 211, 0, 0.8), 0 0 50px rgba(0, 240, 255, 0.4);
      }
      100% {
        transform: scale(1);
        opacity: 0;
        box-shadow: 0 0 60px rgba(255, 211, 0, 0.3);
      }
    }

    .loading-text {
      position: absolute;
      bottom: -120px;
      left: 50%;
      transform: translateX(-50%);
      color: #FFD300;
      font-family: 'Space Grotesk', sans-serif;
      font-size: 1.2rem;
      font-weight: 600;
      text-align: center;
      animation: textGlow 2.5s ease-in-out infinite;
      white-space: nowrap;
      z-index: 25;
    }

    .loading-subtitle {
      position: absolute;
      bottom: -150px;
      left: 50%;
      transform: translateX(-50%);
      color: rgba(0, 240, 255, 0.8);
      font-family: 'Inter', sans-serif;
      font-size: 0.9rem;
      font-weight: 400;
      text-align: center;
      white-space: nowrap;
      z-index: 25;
    }

    .progress-bar-container {
      position: absolute;
      bottom: -190px;
      left: 50%;
      transform: translateX(-50%);
      width: 250px;
      height: 6px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 3px;
      overflow: hidden;
      z-index: 25;
    }

    .progress-bar {
      height: 100%;
      background: linear-gradient(90deg, #FFD300, #00F0FF);
      border-radius: 3px;
      width: 0%;
      transition: width 0.3s ease;
      box-shadow: 0 0 15px rgba(255, 211, 0, 0.6);
    }

    @keyframes textGlow {
      0%, 100% {
        text-shadow: 0 0 12px rgba(255, 211, 0, 0.5);
      }
      50% {
        text-shadow: 0 0 25px rgba(255, 211, 0, 0.8), 0 0 35px rgba(0, 240, 255, 0.3);
      }
    }

    .glow-backdrop {
      position: absolute;
      width: 100%;
      height: 100%;
      background: radial-gradient(
        circle,
        rgba(255, 211, 0, 0.05) 0%,
        rgba(0, 240, 255, 0.03) 40%,
        transparent 70%
      );
      border-radius: 50%;
      animation: backdropPulse 12s ease-in-out infinite;
    }

    @keyframes backdropPulse {
      0%, 100% { opacity: 0.3; }
      50% { opacity: 0.8; }
    }

    /* Responsive design */
    @media (max-width: 700px) {
      .atomic-preloader-wrapper {
        width: 90vw;
        height: 90vw;
        max-width: 500px;
        max-height: 500px;
      }

      .atomic-loader {
        width: 300px;
        height: 300px;
      }

      .loading-text {
        font-size: 1rem;
        bottom: -100px;
      }

      .loading-subtitle {
        font-size: 0.8rem;
        bottom: -125px;
      }

      .progress-bar-container {
        bottom: -160px;
        width: 200px;
      }
    }

    @media (max-width: 480px) {
      .atomic-preloader-wrapper {
        width: 95vw;
        height: 95vw;
        max-width: 400px;
        max-height: 400px;
      }

      .atomic-loader {
        width: 250px;
        height: 250px;
      }

      .loading-text {
        font-size: 0.9rem;
        bottom: -80px;
      }

      .loading-subtitle {
        font-size: 0.75rem;
        bottom: -100px;
      }

      .progress-bar-container {
        bottom: -130px;
        width: 180px;
        height: 4px;
      }
    }
  `;

  // Remove existing styles if present
  const existingStyle = document.getElementById("atomic-preloader-styles");
  if (existingStyle) existingStyle.remove();

  document.head.appendChild(style);

  // Create the HTML structure
  const preloaderHTML = `
    ${config.fullScreen ? '<div class="atomic-preloader-overlay">' : ""}
      <div class="atomic-preloader-wrapper">
        <div class="preloader-ambient-bg"></div>
        <div class="preloader-grid-overlay"></div>

        <div class="atomic-loader">
          <!-- Background glow -->
          <div class="glow-backdrop"></div>

          <!-- Energy field -->
          <div class="energy-field"></div>

          <!-- Particle trails -->
          <div class="orbit orbit-1">
            <div class="particle-trail proton-trail"></div>
          </div>

          <div class="orbit orbit-2">
            <div class="particle-trail electron-trail-1"></div>
          </div>

          <div class="orbit orbit-3">
            <div class="particle-trail electron-trail-2"></div>
          </div>

          <!-- Orbiting particles -->
          <div class="orbit orbit-1">
            <div class="particle proton"></div>
          </div>

          <div class="orbit orbit-2">
            <div class="particle electron"></div>
          </div>

          <div class="orbit orbit-3">
            <div class="particle electron electron-2"></div>
          </div>

          <!-- Central nucleus -->
          <div class="nucleus"></div>

          <!-- Loading text -->
          <div class="loading-text">${config.loadingText}</div>
          <div class="loading-subtitle">${config.subtitle}</div>

          ${
            config.showProgress
              ? `
            <div class="progress-bar-container">
              <div class="progress-bar"></div>
            </div>
          `
              : ""
          }
        </div>
      </div>
    ${config.fullScreen ? "</div>" : ""}
  `;

  container.innerHTML = preloaderHTML;

  // Enhanced atomic loader class
  class AtomicPreloader {
    constructor(container, config) {
      this.container = container;
      this.config = config;
      this.loader = container.querySelector(".atomic-loader");
      this.nucleus = container.querySelector(".nucleus");
      this.particles = container.querySelectorAll(".particle");
      this.overlay = container.querySelector(".atomic-preloader-overlay");
      this.progressBar = container.querySelector(".progress-bar");
      this.isDestroyed = false;
      this.startTime = Date.now();

      this.init();
    }

    init() {
      // Prevent body scroll when fullscreen
      if (this.config.fullScreen) {
        document.body.style.overflow = "hidden";
      }

      this.addOrbitalVariations();
      this.addInteractionEffects();
      this.initCollisionEffects();
      this.startEnergyPulses();
      this.initTimeout();

      if (this.config.showProgress) {
        this.startProgressAnimation();
      }
    }

    addOrbitalVariations() {
      const orbits = this.container.querySelectorAll(".orbit");

      orbits.forEach((orbit, index) => {
        const baseSpeed = [6, 4.2, 8][index];
        const variation = 0.9 + Math.random() * 0.2; // 0.9 to 1.1
        const newDuration = baseSpeed * variation;

        orbit.style.animationDuration = `${newDuration}s`;
      });
    }

    addInteractionEffects() {
      if (this.loader) {
        this.loader.addEventListener("mouseenter", () => {
          this.loader.style.transform = "scale(1.05)";
          this.loader.style.transition = "transform 0.4s ease";
        });

        this.loader.addEventListener("mouseleave", () => {
          this.loader.style.transform = "scale(1)";
        });

        this.loader.addEventListener("click", () => {
          this.createEnergyBurst();
        });
      }
    }

    createEnergyBurst() {
      if (this.isDestroyed) return;

      for (let i = 0; i < 6; i++) {
        setTimeout(() => {
          if (this.isDestroyed) return;

          const burst = document.createElement("div");
          burst.className = "collision-spark";

          const angle = (i * 60 * Math.PI) / 180;
          const radius = 80 + Math.random() * 40;
          const x = 200 + Math.cos(angle) * radius;
          const y = 200 + Math.sin(angle) * radius;

          burst.style.left = x + "px";
          burst.style.top = y + "px";

          if (this.loader) {
            this.loader.appendChild(burst);

            setTimeout(() => {
              if (burst && burst.parentNode) {
                burst.remove();
              }
            }, 1200);
          }
        }, i * 100);
      }
    }

    initCollisionEffects() {
      this.collisionInterval = setInterval(() => {
        if (this.isDestroyed) return;
        this.createCollisionSpark();
      }, 6000);
    }

    createCollisionSpark() {
      if (this.isDestroyed) return;

      const spark = document.createElement("div");
      spark.className = "collision-spark";

      const angle = Math.random() * 2 * Math.PI;
      const radius = 60 + Math.random() * 80;
      const x = 200 + Math.cos(angle) * radius;
      const y = 200 + Math.sin(angle) * radius;

      spark.style.left = x + "px";
      spark.style.top = y + "px";

      if (this.loader) {
        this.loader.appendChild(spark);

        setTimeout(() => {
          if (spark && spark.parentNode) {
            spark.remove();
          }
        }, 1200);
      }
    }

    startEnergyPulses() {
      this.energyInterval = setInterval(() => {
        if (this.isDestroyed) return;

        this.particles.forEach((particle, index) => {
          setTimeout(() => {
            if (this.isDestroyed || !particle) return;

            particle.style.transform = "scale(1.3)";
            particle.style.transition = "transform 0.3s ease";

            setTimeout(() => {
              if (this.isDestroyed || !particle) return;
              particle.style.transform = "scale(1)";
            }, 300);
          }, index * 200);
        });
      }, 10000);
    }

    startProgressAnimation() {
      if (!this.progressBar) return;

      const duration = this.config.timeout;
      const startTime = Date.now();

      this.progressInterval = setInterval(() => {
        if (this.isDestroyed) return;

        const elapsed = Date.now() - startTime;
        const progress = Math.min((elapsed / duration) * 100, 100);

        this.progressBar.style.width = progress + "%";

        if (progress >= 100) {
          clearInterval(this.progressInterval);
        }
      }, 50);
    }

    initTimeout() {
      this.timeoutId = setTimeout(() => {
        if (this.isDestroyed) return;

        this.config.onTimeout();

        if (this.config.autoHide) {
          this.hide();
        }
      }, this.config.timeout);
    }

    updateLoadingText(text, subtitle) {
      if (this.isDestroyed) return;

      const loadingText = this.container.querySelector(".loading-text");
      const loadingSubtitle = this.container.querySelector(".loading-subtitle");

      if (loadingText && text) loadingText.textContent = text;
      if (loadingSubtitle && subtitle) loadingSubtitle.textContent = subtitle;
    }

    setLoadingProgress(percentage) {
      if (this.isDestroyed) return;

      const intensity = percentage / 100;
      if (this.nucleus) {
        this.nucleus.style.filter = `brightness(${1 + intensity * 0.6}) saturate(${1 + intensity * 0.3})`;
      }

      if (this.progressBar) {
        this.progressBar.style.width = percentage + "%";
      }
    }

    hide() {
      if (this.isDestroyed) return;

      const targetElement = this.config.fullScreen
        ? this.overlay
        : this.container;

      if (targetElement) {
        if (this.config.fullScreen) {
          targetElement.classList.add("fade-out");
        } else {
          targetElement.style.opacity = "0";
          targetElement.style.transition = `opacity ${this.config.fadeOutDuration}ms ease-out`;
        }

        setTimeout(() => {
          this.destroy();
        }, this.config.fadeOutDuration);
      }
    }

    show() {
      if (this.isDestroyed) return;

      const targetElement = this.config.fullScreen
        ? this.overlay
        : this.container;

      if (targetElement) {
        if (this.config.fullScreen) {
          targetElement.classList.remove("fade-out");
        } else {
          targetElement.style.opacity = "1";
        }
      }
    }

    complete() {
      if (this.isDestroyed) return;

      this.config.onComplete();

      if (this.config.autoHide) {
        this.hide();
      }
    }

    destroy() {
      if (this.isDestroyed) return;

      this.isDestroyed = true;

      // Clear intervals and timeouts
      if (this.timeoutId) clearTimeout(this.timeoutId);
      if (this.collisionInterval) clearInterval(this.collisionInterval);
      if (this.energyInterval) clearInterval(this.energyInterval);
      if (this.progressInterval) clearInterval(this.progressInterval);

      // Restore body scroll
      if (this.config.fullScreen) {
        document.body.style.overflow = "";
      }

      // Remove elements
      if (this.container) {
        this.container.innerHTML = "";
      }

      // Remove styles
      const style = document.getElementById("atomic-preloader-styles");
      if (style) style.remove();
    }

    // Public methods for external control
    getElapsedTime() {
      return Date.now() - this.startTime;
    }

    getRemainingTime() {
      return Math.max(0, this.config.timeout - this.getElapsedTime());
    }

    isActive() {
      return !this.isDestroyed;
    }
  }

  // Initialize the atomic preloader
  const atomicPreloader = new AtomicPreloader(container, config);

  // Return the preloader instance for external control
  return atomicPreloader;
}

// Alternative function for quick full-screen usage
export function showAtomicPreloader(options = {}) {
  // Create a container if none exists
  let container = document.getElementById("atomic-preloader-container");

  if (!container) {
    container = document.createElement("div");
    container.id = "atomic-preloader-container";
    document.body.appendChild(container);
  }

  // Force full-screen mode
  options.fullScreen = true;

  return renderAtomicPreloader("atomic-preloader-container", options);
}

// Utility function to hide all active preloaders
export function hideAllAtomicPreloaders() {
  const containers = document.querySelectorAll(".atomic-preloader-overlay");
  containers.forEach((container) => {
    container.classList.add("fade-out");
    setTimeout(() => {
      if (container.parentNode) {
        container.parentNode.removeChild(container);
      }
    }, 800);
  });

  // Restore body scroll
  document.body.style.overflow = "";
}
