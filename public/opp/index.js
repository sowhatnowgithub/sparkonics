export function renderSparkonicsOpportunities(containerId) {
  const container = document.getElementById(containerId);
  if (!container) return console.error("Container not found: ", containerId);

  const style = document.createElement("style");
  style.innerHTML = `
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap');
    body {
      margin: 0;
      font-family: 'Inter', system-ui, sans-serif;
      background: linear-gradient(135deg, #000818 0%, #001122 50%, #000510 100%);
      min-height: 100vh;
    }

    .ambient-bg {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background:
        radial-gradient(circle at 20% 80%, rgba(0, 240, 255, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 211, 0, 0.1) 0%, transparent 50%);
      z-index: 0;
      pointer-events: none;
      animation: ambientShift 20s ease-in-out infinite;
    }

    @keyframes ambientShift {
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

    .dynamic-waves {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      z-index: 1;
      pointer-events: none;
      overflow: hidden;
    }

    .wave {
      position: absolute;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg,
        transparent 40%,
        rgba(0, 240, 255, 0.02) 50%,
        transparent 60%);
      animation: waveMove 15s linear infinite;
    }

    .wave:nth-child(1) {
      animation-duration: 20s;
      animation-delay: -5s;
    }

    .wave:nth-child(2) {
      background: linear-gradient(-45deg,
        transparent 40%,
        rgba(255, 211, 0, 0.015) 50%,
        transparent 60%);
      animation-duration: 25s;
      animation-delay: -10s;
    }

    @keyframes waveMove {
      0% { transform: translate(-50%, -50%) rotate(0deg); }
      100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    .energy-lines {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      z-index: 1;
      pointer-events: none;
    }

    .energy-line {
      position: absolute;
      height: 1px;
      background: linear-gradient(90deg,
        transparent,
        rgba(0, 240, 255, 0.4),
        transparent);
      animation: energyFlow 8s linear infinite;
    }

    @keyframes energyFlow {
      0% {
        left: -100%;
        width: 100px;
        opacity: 0;
      }
      10% { opacity: 1; }
      90% { opacity: 1; }
      100% {
        left: 100%;
        width: 100px;
        opacity: 0;
      }
    }

    .preloader {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: linear-gradient(135deg, #000818 0%, #001122 50%, #000510 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      z-index: 9999;
      transition: opacity 0.8s ease, visibility 0.8s ease;
    }

    .preloader.hidden {
      opacity: 0;
      visibility: hidden;
    }

    .preloader-content {
      text-align: center;
      position: relative;
    }

    .spark-loader {
      width: 120px;
      height: 120px;
      position: relative;
      margin-bottom: 32px;
    }

    .spark-ring {
      position: absolute;
      width: 100%;
      height: 100%;
      border: 2px solid transparent;
      border-radius: 50%;
      animation: sparkRotate 2s linear infinite;
    }

    .spark-ring:nth-child(1) {
      border-top: 2px solid #00F0FF;
      border-right: 2px solid rgba(0, 240, 255, 0.3);
      animation-duration: 2s;
    }

    .spark-ring:nth-child(2) {
      border-bottom: 2px solid #FFD300;
      border-left: 2px solid rgba(255, 211, 0, 0.3);
      animation-duration: 1.5s;
      animation-direction: reverse;
    }

    .spark-core {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 40px;
      height: 40px;
      background: radial-gradient(circle, #FFD300 20%, transparent 70%);
      border-radius: 50%;
      animation: sparkPulse 1.5s ease-in-out infinite;
    }

    @keyframes sparkRotate {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @keyframes sparkPulse {
      0%, 100% {
        transform: translate(-50%, -50%) scale(1);
        box-shadow: 0 0 20px rgba(255, 211, 0, 0.5);
      }
      50% {
        transform: translate(-50%, -50%) scale(1.2);
        box-shadow: 0 0 30px rgba(255, 211, 0, 0.8);
      }
    }

    .loading-text {
      color: #FFD300;
      font-family: 'Space Grotesk', sans-serif;
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 12px;
      animation: textGlow 2s ease-in-out infinite;
    }

    .loading-subtitle {
      color: rgba(0, 240, 255, 0.8);
      font-size: 0.9rem;
      font-weight: 400;
    }

    .error-message {
      background: rgba(255, 100, 100, 0.1);
      border: 1px solid rgba(255, 100, 100, 0.3);
      color: #ff6464;
      padding: 16px;
      border-radius: 8px;
      text-align: center;
      margin: 20px 0;
      font-size: 0.9rem;
    }

    .loading-message {
      background: rgba(0, 240, 255, 0.1);
      border: 1px solid rgba(0, 240, 255, 0.3);
      color: #00F0FF;
      padding: 16px;
      border-radius: 8px;
      text-align: center;
      margin: 20px 0;
      font-size: 0.9rem;
    }

    @keyframes textGlow {
      0%, 100% { text-shadow: 0 0 10px rgba(255, 211, 0, 0.5); }
      50% { text-shadow: 0 0 20px rgba(255, 211, 0, 0.8), 0 0 30px rgba(0, 240, 255, 0.3); }
    }

    .grid-overlay {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background-image:
        linear-gradient(rgba(0, 240, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 240, 255, 0.03) 1px, transparent 1px);
      background-size: 50px 50px;
      z-index: 1;
      pointer-events: none;
    }

    .particle {
      position: absolute;
      border-radius: 50%;
      animation: float 6s infinite ease-in-out;
      opacity: 0.7;
      transition: all 0.3s ease;
      z-index: 1;
    }
    .electron {
      background: #00F0FF;
      width: 5px; height: 5px;
      box-shadow: 0 0 8px #00F0FF;
    }
    .proton {
      background: #FFD300;
      width: 7px; height: 7px;
      box-shadow: 0 0 10px #FFD300;
    }
    @keyframes float {
      0%, 100% { transform: translate(0, 0) rotate(0deg); }
      25% { transform: translate(60px, -40px) rotate(90deg); }
      50% { transform: translate(-40px, -80px) rotate(180deg); }
      75% { transform: translate(-80px, 40px) rotate(270deg); }
    }

    .collision-effect {
      position: absolute;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.9) 0%, rgba(0, 240, 255, 0.4) 50%, transparent 100%);
      animation: collisionBurst 0.8s ease-out forwards;
      pointer-events: none;
      z-index: 2;
    }

    @keyframes collisionBurst {
      0% {
        transform: scale(0);
        opacity: 1;
        box-shadow: 0 0 0px rgba(255, 255, 255, 0.8);
      }
      50% {
        transform: scale(1.5);
        opacity: 0.8;
        box-shadow: 0 0 25px rgba(0, 240, 255, 0.6), 0 0 50px rgba(255, 211, 0, 0.3);
      }
      100% {
        transform: scale(2.5);
        opacity: 0;
        box-shadow: 0 0 60px rgba(0, 240, 255, 0.2);
      }
    }

    .content-wrapper {
      position: relative;
      z-index: 2;
      padding: 60px 40px;
      max-width: 1400px;
      margin: 0 auto;
    }

    .header {
      text-align: center;
      margin-bottom: 60px;
    }

    .header h1 {
      font-family: 'Space Grotesk', sans-serif;
      font-size: clamp(2.5rem, 5vw, 3.5rem);
      font-weight: 700;
      color: #FFD300;
      margin: 0 0 16px 0;
      letter-spacing: -0.02em;
      position: relative;
    }

    .header h1::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 120px;
      height: 2px;
      background: linear-gradient(90deg, transparent, #00F0FF, transparent);
    }

    .header p {
      color: rgba(255, 255, 255, 0.7);
      font-size: 1.1rem;
      margin: 0;
      max-width: 600px;
      margin: 0 auto;
    }

    .opportunities-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
      gap: 32px;
      margin-top: 40px;
    }

    .opportunity-card {
      position: relative;
      height: 340px;
      perspective: 1000px;
      cursor: pointer;
    }

    .card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.6s cubic-bezier(0.4, 0.0, 0.2, 1);
      transform-style: preserve-3d;
    }

    .opportunity-card:hover .card-inner {
      transform: translateZ(0) rotateY(0deg) scale(1.02);
    }

    .opportunity-card.flipped .card-inner {
      transform: rotateY(180deg);
    }

    .card-face {
      position: absolute;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      border-radius: 16px;
      padding: 28px;
      box-sizing: border-box;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card-front {
      background: rgba(0, 10, 20, 0.6);
      backdrop-filter: blur(20px);
      border-image: linear-gradient(135deg, rgba(0, 240, 255, 0.3), transparent, rgba(255, 211, 0, 0.3)) 1;
    }

    .card-back {
      background: rgba(5, 15, 25, 0.7);
      backdrop-filter: blur(20px);
      transform: rotateY(180deg);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border-image: linear-gradient(135deg, rgba(255, 211, 0, 0.4), transparent, rgba(0, 240, 255, 0.3)) 1;
    }

    .opportunity-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .opportunity-title {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 1.4rem;
      font-weight: 600;
      color: #FFD300;
      margin: 0;
      line-height: 1.2;
    }

    .opportunity-id {
      background: rgba(0, 240, 255, 0.2);
      color: #00F0FF;
      padding: 4px 8px;
      border-radius: 6px;
      font-size: 0.75rem;
      font-weight: 500;
      border: 1px solid rgba(0, 240, 255, 0.3);
    }

    .opportunity-desc {
      color: rgba(255, 255, 255, 0.8);
      font-size: 0.95rem;
      line-height: 1.5;
      margin-bottom: 20px;
    }

    .tags {
      display: flex;
      gap: 8px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    .tag {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
      border: 1px solid;
    }

    .tag-type {
      background: rgba(0, 240, 255, 0.15);
      color: #00F0FF;
      border-color: rgba(0, 240, 255, 0.3);
    }

    .tag-domain {
      background: rgba(255, 211, 0, 0.15);
      color: #FFD300;
      border-color: rgba(255, 211, 0, 0.3);
    }

    .opportunity-meta {
      display: grid;
      gap: 8px;
      font-size: 0.85rem;
    }

    .meta-item {
      display: flex;
      align-items: center;
      gap: 8px;
      color: rgba(255, 255, 255, 0.7);
    }

    .meta-icon {
      width: 16px;
      text-align: center;
    }

    .back-content h3 {
      color: #FFD300;
      font-size: 1.2rem;
      font-weight: 600;
      margin: 0 0 20px 0;
      font-family: 'Space Grotesk', sans-serif;
    }

    .detail-row {
      margin-bottom: 16px;
      line-height: 1.4;
    }

    .detail-label {
      color: #00F0FF;
      font-weight: 500;
      font-size: 0.9rem;
      display: block;
      margin-bottom: 4px;
    }

    .detail-value {
      color: rgba(255, 255, 255, 0.8);
      font-size: 0.9rem;
    }

    .apply-btn {
      background: linear-gradient(135deg, #FFD300 0%, #FFA500 100%);
      color: #000;
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
      font-size: 0.95rem;
      border: none;
      cursor: pointer;
      z-index: 10;
      position: relative;
    }

    .apply-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(255, 211, 0, 0.4);
    }

    .flip-indicator {
      position: absolute;
      top: 16px;
      right: 16px;
      color: rgba(255, 255, 255, 0.4);
      font-size: 0.8rem;
      transition: color 0.3s ease;
    }

    .opportunity-card:hover .flip-indicator {
      color: #00F0FF;
    }

    @media (max-width: 768px) {
      .content-wrapper {
        padding: 40px 20px;
      }

      .opportunities-grid {
        grid-template-columns: 1fr;
        gap: 24px;
      }
    }
  `;
  document.head.appendChild(style);

  // Create preloader
  const preloader = document.createElement("div");
  preloader.className = "preloader";
  preloader.innerHTML = `
    <div class="preloader-content">
      <div class="spark-loader">
        <div class="spark-ring"></div>
        <div class="spark-ring"></div>
        <div class="spark-core"></div>
      </div>
      <div class="loading-text">Initializing Sparkonics</div>
      <div class="loading-subtitle">Loading opportunities...</div>
    </div>
  `;
  document.body.appendChild(preloader);

  // Create dynamic background elements
  const ambientBg = document.createElement("div");
  ambientBg.className = "ambient-bg";
  document.body.appendChild(ambientBg);

  const gridOverlay = document.createElement("div");
  gridOverlay.className = "grid-overlay";
  document.body.appendChild(gridOverlay);

  // Create dynamic waves
  const dynamicWaves = document.createElement("div");
  dynamicWaves.className = "dynamic-waves";
  dynamicWaves.innerHTML = `
    <div class="wave"></div>
    <div class="wave"></div>
  `;
  document.body.appendChild(dynamicWaves);

  // Create energy lines
  const energyLines = document.createElement("div");
  energyLines.className = "energy-lines";
  document.body.appendChild(energyLines);

  // Spawn energy lines periodically
  const spawnEnergyLine = () => {
    const line = document.createElement("div");
    line.className = "energy-line";
    line.style.cssText = `
      top: ${Math.random() * 100}vh;
      animation-delay: ${Math.random() * 2}s;
    `;
    energyLines.appendChild(line);

    setTimeout(() => line.remove(), 8000);
  };

  setInterval(spawnEnergyLine, 3000);

  // Enhanced particle system with collision detection
  const particles = [];

  const createCollisionEffect = (x, y) => {
    const collision = document.createElement("div");
    collision.className = "collision-effect";
    collision.style.left = x + "px";
    collision.style.top = y + "px";
    document.body.appendChild(collision);

    setTimeout(() => collision.remove(), 800);
  };

  const spawnParticles = () => {
    // Spawn more particles (increased from 8 to 20)
    for (let i = 0; i < 20; i++) {
      const isElectron = Math.random() > 0.4; // More protons (60% protons, 40% electrons)
      const particle = document.createElement("div");
      particle.className = `particle ${isElectron ? "electron" : "proton"}`;

      const startX = Math.random() * window.innerWidth;
      const startY = Math.random() * window.innerHeight;

      particle.style.cssText = `
        top: ${startY}px;
        left: ${startX}px;
        animation-delay: ${Math.random() * 6}s;
      `;

      particle.particleData = {
        type: isElectron ? "electron" : "proton",
        x: startX,
        y: startY,
        element: particle,
      };

      particles.push(particle.particleData);
      document.body.appendChild(particle);

      setTimeout(
        () => {
          particle.remove();
          const index = particles.indexOf(particle.particleData);
          if (index > -1) particles.splice(index, 1);
        },
        6000 + Math.random() * 3000,
      );
    }
  };

  // Check for collisions between particles
  const checkCollisions = () => {
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const p1 = particles[i];
        const p2 = particles[j];

        if (!p1.element || !p2.element) continue;

        // Only collide different particle types
        if (p1.type !== p2.type) {
          const rect1 = p1.element.getBoundingClientRect();
          const rect2 = p2.element.getBoundingClientRect();

          const distance = Math.sqrt(
            Math.pow(rect1.left - rect2.left, 2) +
              Math.pow(rect1.top - rect2.top, 2),
          );

          if (distance < 15) {
            // Collision threshold
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
  setInterval(spawnParticles, 8000); // More frequent spawning
  setInterval(checkCollisions, 100); // Check collisions every 100ms

  async function loadMainUI() {
    container.className = "content-wrapper";

    // Header
    const header = document.createElement("div");
    header.className = "header";
    header.innerHTML = `
      <h1>⚡ Sparkonics Opportunities</h1>
      <p>Discover cutting-edge electrical engineering opportunities and innovative technology ventures</p>
    `;
    container.appendChild(header);

    // Grid
    const grid = document.createElement("div");
    grid.className = "opportunities-grid";
    container.appendChild(grid);

    // Fetch opportunities from API
    async function fetchOpportunities() {
      try {
        // Show loading message
        const loadingMsg = document.createElement("div");
        loadingMsg.className = "loading-message";
        loadingMsg.innerHTML = "🔄 Fetching opportunities from API...";
        grid.appendChild(loadingMsg);

        const response = await fetch("/api/opp");
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const opportunities = await response.json();

        // Remove loading message
        loadingMsg.remove();

        return Array.isArray(opportunities) ? opportunities : [];
      } catch (error) {
        console.error("Error fetching opportunities:", error);

        // Remove loading message and show error
        const loadingMsg = grid.querySelector(".loading-message");
        if (loadingMsg) loadingMsg.remove();

        const errorMsg = document.createElement("div");
        errorMsg.className = "error-message";
        errorMsg.innerHTML = `❌ Failed to fetch opportunities from API: ${error.message}<br>Using fallback data...`;
        grid.appendChild(errorMsg);

        // Remove error message after 5 seconds
        setTimeout(() => errorMsg.remove(), 5000);

        // Fallback to mock data if API fails
        return Array.from({ length: 4 }, (_, i) => ({
          OppId: `SP${String(i + 1).padStart(3, "0")}`,
          OppName: `This is dummy dataAdvanced ${i % 2 === 0 ? "Electronics" : "Power Systems"} Initiative`,
          OppDesc: `Explore innovative solutions in ${i % 2 === 0 ? "circuit design and embedded systems" : "renewable energy and smart grids"}. Work with cutting-edge technology and industry experts.`,
          OppLink: "https://example.com/apply",
          OppDomain: i % 2 === 0 ? "Electronics" : "Power Systems",
          OppValidFrom: "2025-08-01",
          OppValidEnd: "2025-08-15",
          OppCreatedAt: `2025-07-${12 + i}`,
          OppEligibility:
            "Undergraduate & Postgraduate Students in Electrical Engineering",
          OppOrganiser: `Sparkonics Research Division ${Math.floor(i / 2) + 1}`,
          OppApplicationProcedure:
            "Submit application through official portal with academic transcripts, project portfolio, and statement of purpose",
          OppLocation:
            i % 3 === 0 ? "Hybrid" : i % 2 === 0 ? "Remote" : "On Campus",
          OppType: i % 2 === 0 ? "Research Internship" : "Industry Project",
        }));
      }
    }

    const opportunities = await fetchOpportunities();

    // Handle empty opportunities
    if (!opportunities || opportunities.length === 0) {
      const emptyMsg = document.createElement("div");
      emptyMsg.className = "loading-message";
      emptyMsg.innerHTML =
        "📭 No opportunities available at the moment. Please check back later.";
      grid.appendChild(emptyMsg);
      return;
    }

    opportunities.forEach((opp) => {
      const card = document.createElement("div");
      card.className = "opportunity-card";

      card.innerHTML = `
        <div class="card-inner">
          <div class="card-face card-front">
            <div class="flip-indicator">Click to flip →</div>
            <div class="opportunity-header">
              <h3 class="opportunity-title">${opp.OppName}</h3>
              <span class="opportunity-id">${opp.OppId}</span>
            </div>

            <p class="opportunity-desc">${opp.OppDesc}</p>

            <div class="tags">
              <span class="tag tag-type">${opp.OppType}</span>
              <span class="tag tag-domain">${opp.OppDomain}</span>
            </div>

            <div class="opportunity-meta">
              <div class="meta-item">
                <span class="meta-icon">📍</span>
                <span>${opp.OppLocation}</span>
              </div>
              <div class="meta-item">
                <span class="meta-icon">📅</span>
                <span>${opp.OppValidFrom} - ${opp.OppValidEnd}</span>
              </div>
              <div class="meta-item">
                <span>Created At:${opp.OppCreatedAt}</span>
              </div>
              <div class="meta-item">
                <span class="meta-icon">🏢</span>
                <span>${opp.OppOrganiser}</span>
              </div>
            </div>
          </div>

          <div class="card-face card-back">
            <div class="back-content">
              <h3>Application Details</h3>

              <div class="detail-row">
                <span class="detail-label">Eligibility</span>
                <span class="detail-value">${opp.OppEligibility}</span>
              </div>

              <div class="detail-row">
                <span class="detail-label">Application Process</span>
                <span class="detail-value">${opp.OppApplicationProcedure}</span>
              </div>
            </div>

            <a href="${opp.OppLink}" class="apply-btn" target="_blank">
              <span>Apply Now</span>
              <span>→</span>
            </a>
          </div>
        </div>
      `;

      // Add click event to card (excluding apply button)
      card.addEventListener("click", (e) => {
        // Don't flip if clicking on apply button
        if (e.target.closest(".apply-btn")) {
          return; // Let the link handle the click
        }

        e.preventDefault();
        e.stopPropagation();
        card.classList.toggle("flipped");

        // Update flip indicator
        const indicator = card.querySelector(".flip-indicator");
        indicator.textContent = card.classList.contains("flipped")
          ? "← Click to flip back"
          : "Click to flip →";
      });

      // Ensure apply button works properly
      const applyBtn = card.querySelector(".apply-btn");
      applyBtn.addEventListener("click", (e) => {
        e.stopPropagation(); // Prevent card flip
        // The href will handle the navigation
      });

      grid.appendChild(card);
    });
  }

  // Simple fade-in load with preloader
  container.style.opacity = "0";
  container.style.transition = "opacity 0.6s ease";

  // Hide preloader and show content
  setTimeout(async () => {
    preloader.classList.add("hidden");
    setTimeout(async () => {
      await loadMainUI();
      container.style.opacity = "1";
      preloader.remove();
    }, 800);
  }, 2500);
}
