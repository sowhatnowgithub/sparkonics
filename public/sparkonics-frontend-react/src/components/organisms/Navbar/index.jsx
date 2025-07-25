import { useEffect, useRef, useState } from "react";
import "./index.css";
import { Link, NavLink } from "react-router";
/**
 * A futuristic-themed component that renders a navigation bar with animated
 * particles (protons and electrons) flowing along connected wires.
 *
 * @component
 * @example
 * return <FuturisticNavbar />
 */
function FuturisticNavbar() {
  // Refs for DOM elements we need to interact with
  const particlesRef = useRef(null);
  const navbarRef = useRef(null);

  // State to hold window dimensions for responsive path calculations
  const [windowSize, setWindowSize] = useState({ width: 0, height: 0 });

  // Refs to manage the animation loop and particle data
  const animationFrameRef = useRef(null);
  const particlesListRef = useRef([]);

  // --- 1. Setup and Resize Handling ---
  // This effect runs once to get initial window size and add a resize listener.
  useEffect(() => {
    const handleResize = () => {
      setWindowSize({ width: window.innerWidth, height: window.innerHeight });
    };

    handleResize(); // Set initial size
    window.addEventListener("resize", handleResize);

    // Cleanup: remove the event listener when the component unmounts
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  // --- 2. Main Animation Effect ---
  // This effect runs whenever the window size changes.
  // It's responsible for creating, animating, and cleaning up all particles.
  useEffect(() => {
    // Ensure both the navbar and the SVG canvas are rendered
    if (!particlesRef.current || !navbarRef.current) return;

    const svgCanvas = particlesRef.current;
    const navbar = navbarRef.current;
    const navbarRect = navbar.getBoundingClientRect();

    // Clear any previous particles and animations to prevent memory leaks
    svgCanvas.innerHTML = "";
    particlesListRef.current = [];
    if (animationFrameRef.current) {
      cancelAnimationFrame(animationFrameRef.current);
    }

    // --- Particle Creation (from App1.jsx) ---
    // These functions create the detailed SVG elements for our particles.

    const createProton = () => {
      const g = document.createElementNS("http://www.w3.org/2000/svg", "g");
      const circle = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "circle",
      );
      circle.setAttribute("r", 8);
      circle.setAttribute("fill", "rgba(144, 252, 253, 0.2)");
      g.appendChild(circle);

      const path = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "path",
      );
      path.setAttribute("d", "M-5,0 L5,0 M0,-5 L0,5");
      path.setAttribute("stroke", "rgb(246, 231, 82)");
      path.setAttribute("stroke-width", 2);
      g.appendChild(path);

      return g;
    };

    const createElectron = () => {
      const g = document.createElementNS("http://www.w3.org/2000/svg", "g");
      const circle = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "circle",
      );
      circle.setAttribute("r", 7);
      circle.setAttribute("fill", "rgba(246, 231, 82, 0.2)");
      g.appendChild(circle);

      const line = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "line",
      );
      line.setAttribute("x1", -4);
      line.setAttribute("y1", 0);
      line.setAttribute("x2", 4);
      line.setAttribute("y2", 0);
      line.setAttribute("stroke", "rgb(144, 252, 253)");
      line.setAttribute("stroke-width", 2.5);
      g.appendChild(line);

      return g;
    };

    // --- Wire Path Calculation ---
    // This function calculates the points for the wire paths based on navbar position.
    const getWirePath = (side) => {
      const navCenterY = navbarRect.top + navbarRect.height / 2;

      if (side === "left") {
        return `M ${navbarRect.left} ${navCenterY} H 80 A 40,40 0 0 0 40,${navCenterY + 40} V ${windowSize.height - 40}`;
      } else {
        return `M ${navbarRect.right} ${navCenterY} H ${windowSize.width - 80} A 40,40 0 0 1 ${windowSize.width - 40},${navCenterY + 40} V ${windowSize.height - 40}`;
      }
    };

    const leftWirePath = document.createElementNS(
      "http://www.w3.org/2000/svg",
      "path",
    );
    leftWirePath.setAttribute("d", getWirePath("left"));
    const rightWirePath = document.createElementNS(
      "http://www.w3.org/2000/svg",
      "path",
    );
    rightWirePath.setAttribute("d", getWirePath("right"));

    // --- Particle Animation Logic (from App.jsx) ---
    // This function returns a new function that, when called, moves a particle along a path.
    const animateParticleOnPath = (particle, pathElement, speed) => {
      const pathLength = pathElement.getTotalLength();
      let distance = Math.random() * pathLength; // Start at a random position

      return () => {
        distance += speed;
        if (distance > pathLength) {
          distance = 0;
        }

        const point = pathElement.getPointAtLength(distance);
        particle.setAttribute("transform", `translate(${point.x}, ${point.y})`);
      };
    };

    // --- Particle Initialization ---
    const protonCount = 15;
    for (let i = 0; i < protonCount; i++) {
      const proton = createProton();
      svgCanvas.appendChild(proton);
      const speed = 0.8 + Math.random() * 0.4;
      const animate = animateParticleOnPath(proton, leftWirePath, speed);
      particlesListRef.current.push({ animate });
    }

    const electronCount = 18;
    for (let i = 0; i < electronCount; i++) {
      const electron = createElectron();
      svgCanvas.appendChild(electron);
      const speed = 1 + Math.random() * 0.5;
      const animate = animateParticleOnPath(electron, rightWirePath, speed);
      particlesListRef.current.push({ animate });
    }

    // --- Animation Loop ---
    const loop = () => {
      // Animate every particle in the list
      particlesListRef.current.forEach((p) => p.animate());
      animationFrameRef.current = requestAnimationFrame(loop);
    };

    loop(); // Start the animation

    // Navbar glow effect (for added flair)
    const glowInterval = setInterval(() => {
      const intensity = 0.4 + Math.sin(Date.now() * 0.002) * 0.3;
      navbar.style.boxShadow = `0 0 ${15 + intensity * 10}px 3px rgba(144, 252, 253, ${intensity})`;
      navbar.style.borderColor = `rgba(144, 252, 253, ${0.4 + intensity * 0.3})`;
    }, 50);

    // Cleanup function for this effect
    return () => {
      if (animationFrameRef.current) {
        cancelAnimationFrame(animationFrameRef.current);
      }
      clearInterval(glowInterval);
    };
  }, [windowSize]); // Rerun effect if windowSize changes

  // --- 3. Dynamic Path for Wires in JSX ---
  // Recalculate paths for rendering based on the current navbar position.
  const navbarRect = navbarRef.current?.getBoundingClientRect();
  const leftWirePathD = navbarRect
    ? `M ${navbarRect.left} ${navbarRect.top + navbarRect.height / 2} H 80 A 40,40 0 0 0 40,${navbarRect.top + navbarRect.height / 2 + 40} V ${windowSize.height - 40}`
    : "";
  const rightWirePathD = navbarRect
    ? `M ${navbarRect.right} ${navbarRect.top + navbarRect.height / 2} H ${windowSize.width - 80} A 40,40 0 0 1 ${windowSize.width - 40},${navbarRect.top + navbarRect.height / 2 + 40} V ${windowSize.height - 40}`
    : "";

  // --- 4. Component Rendering ---
  return (
    <div
      className="relative z-10 w-full min-h-screen flex flex-col items-center"
      style={{ paddingTop: "100px" }} // Adjust if your navbar is taller/shorter
    >
      {/* Background canvas */}
      <canvas
        className="absolute inset-0 w-full h-full"
        style={{
          background:
            "radial-gradient(ellipse at center, rgba(10, 20, 35, 1) 0%, rgba(0, 0, 0, 1) 70%)",
        }}
      />

      {/* Copper wire SVG */}
      <svg
        className="absolute inset-0 w-full h-full pointer-events-none"
        style={{ zIndex: 5 }}
      >
        <defs>
          <linearGradient
            id="copperGradient"
            x1="0%"
            y1="0%"
            x2="100%"
            y2="100%"
          >
            <stop offset="0%" stopColor="#b87333" />
            <stop offset="50%" stopColor="#ffcc99" />
            <stop offset="100%" stopColor="#b87333" />
          </linearGradient>
          <filter id="wireGlow">
            <feGaussianBlur stdDeviation="2.5" result="coloredBlur" />
          </filter>
        </defs>

        {/* Left Wire */}
        <path
          d={leftWirePathD}
          stroke="#3d2817"
          strokeWidth="8"
          fill="none"
          strokeLinecap="round"
        />
        <path
          d={leftWirePathD}
          stroke="url(#copperGradient)"
          strokeWidth="4"
          fill="none"
          strokeLinecap="round"
          filter="url(#wireGlow)"
        />

        {/* Right Wire */}
        <path
          d={rightWirePathD}
          stroke="#3d2817"
          strokeWidth="8"
          fill="none"
          strokeLinecap="round"
        />
        <path
          d={rightWirePathD}
          stroke="url(#copperGradient)"
          strokeWidth="4"
          fill="none"
          strokeLinecap="round"
          filter="url(#wireGlow)"
        />
      </svg>

      {/* Particle SVG Layer */}
      <svg
        ref={particlesRef}
        className="absolute inset-0 w-full h-full pointer-events-none"
        style={{ zIndex: 15 }}
      />

      {/* Navbar (overlay on top) */}
      <nav
        ref={navbarRef}
        className="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 rounded-2xl backdrop-blur-md border"
        id="navbar"
        style={{
          minWidth: "500px",
          background: "rgba(0, 10, 20, 0.6)",
          borderColor: "rgba(144, 252, 253, 0.6)",
          boxShadow: "0 0 15px 3px rgba(144, 252, 253, 0.3)",
        }}
      >
        <ul className="flex items-center gap-6">
          <li>
            <NavLink
              to="/events/"
              className="text-cyan-300 hover:text-yellow-300 transition-colors duration-300 font-medium"
            >
              Events
            </NavLink>
          </li>
          <li>
            <NavLink
              to="/gallery"
              className="text-cyan-300 hover:text-yellow-300 transition-colors duration-300 font-medium"
            >
              Projects/Gallery
            </NavLink>
          </li>
          <li>
            <NavLink
              to="/profs"
              className="text-cyan-300 hover:text-yellow-300 transition-colors duration-300 font-medium"
            >
              Professor
            </NavLink>
          </li>
          <li>
            <a
              href="/thrds"
              target="_blank"
              rel="noopener noreferrer"
              className="text-cyan-300 hover:text-yellow-300 transition-colors duration-300 font-medium"
            >
              Thrds
            </a>
          </li>
          <li>
            <NavLink
              to="/teams/"
              className="text-cyan-300 hover:text-yellow-300 transition-colors duration-300 font-medium"
            >
              Team
            </NavLink>
          </li>
          <li>
            <NavLink
              to="/oa"
              className="text-cyan-300 hover:text-yellow-300 transition-colors duration-300 font-medium"
            >
              OA
            </NavLink>
          </li>
          <li>
            <NavLink
              to="/opp/"
              className="text-cyan-300 hover:text-yellow-300 transition-colors duration-300 font-medium"
            >
              Opportunities
            </NavLink>
          </li>
          <li>
            <NavLink
              to="/dev"
              className="text-cyan-300 hover:text-yellow-300 transition-colors duration-300 font-medium"
            >
              DevX
            </NavLink>
          </li>
          <li>
            <a
              href="/admin/"
              target="_blank"
              rel="noopener noreferrer"
              className="text-cyan-300 hover:text-yellow-300 transition-colors duration-300 font-medium"
            >
              Admin
            </a>
          </li>
        </ul>
      </nav>

      {/* Your page content goes below */}
      <div className="relative z-10 w-full min-h-screen flex flex-col items-center">
        {/* Add page content here */}
      </div>
    </div>
  );
}

export default FuturisticNavbar;
