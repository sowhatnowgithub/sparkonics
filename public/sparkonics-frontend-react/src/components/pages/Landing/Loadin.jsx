import React, { useEffect, useState } from "react";

// SVG1 - Clean cyan text on pure black background
const SVG1 = () => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 1024 1024"
    width="100vw"
    height="100vh"
    style={{ display: "block" }}
  >
    <rect width="100%" height="100%" fill="#000000" />
    <text
      x="512"
      y="520"
      fontFamily="'Segoe UI', -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif"
      fontSize="90"
      fontWeight="300"
      textAnchor="middle"
      fill="#00d4ff"
      letterSpacing="2px"
    >
      Sparkonics
    </text>
  </svg>
);

// SVG2 - Intense neon glow effect on text only
const SVG2 = () => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 1024 1024"
    width="100vw"
    height="100vh"
    style={{ display: "block" }}
  >
    <defs>
      {/* Multiple glow layers for professional neon effect */}
      <filter id="intenseNeonGlow" x="-50%" y="-50%" width="200%" height="200%">
        <feGaussianBlur stdDeviation="3" result="innerGlow" />
        <feGaussianBlur stdDeviation="8" result="midGlow" />
        <feGaussianBlur stdDeviation="15" result="outerGlow" />
        <feMerge>
          <feMergeNode in="outerGlow" />
          <feMergeNode in="midGlow" />
          <feMergeNode in="innerGlow" />
          <feMergeNode in="SourceGraphic" />
        </feMerge>
      </filter>
      <linearGradient id="neonTextGradient" x1="0%" y1="0%" x2="0%" y2="100%">
        <stop offset="0%" stopColor="#ffffff" />
        <stop offset="20%" stopColor="#87ceeb" />
        <stop offset="50%" stopColor="#00d4ff" />
        <stop offset="80%" stopColor="#0099cc" />
        <stop offset="100%" stopColor="#006699" />
      </linearGradient>
    </defs>
    <rect width="100%" height="100%" fill="#000000" />
    {/* Base glow layer */}
    <text
      x="512"
      y="520"
      fontFamily="'Segoe UI', -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif"
      fontSize="90"
      fontWeight="300"
      textAnchor="middle"
      fill="#00d4ff"
      opacity="0.8"
      filter="url(#intenseNeonGlow)"
      letterSpacing="2px"
    >
      Sparkonics
    </text>
    {/* Main text with gradient */}
    <text
      x="512"
      y="520"
      fontFamily="'Segoe UI', -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif"
      fontSize="90"
      fontWeight="300"
      textAnchor="middle"
      fill="url(#neonTextGradient)"
      letterSpacing="2px"
    >
      Sparkonics
    </text>
  </svg>
);

// SVG3 - Final professional logo with subtle animations
const SVG3 = ({ showTagline = true }) => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 1024 1024"
    width="100vw"
    height="100vh"
    style={{ display: "block" }}
  >
    <defs>
      {/* Professional glow effects */}
      <filter
        id="professionalGlow"
        x="-40%"
        y="-40%"
        width="180%"
        height="180%"
      >
        <feGaussianBlur stdDeviation="2" result="innerGlow" />
        <feGaussianBlur stdDeviation="6" result="midGlow" />
        <feGaussianBlur stdDeviation="12" result="outerGlow" />
        <feMerge>
          <feMergeNode in="outerGlow" />
          <feMergeNode in="midGlow" />
          <feMergeNode in="innerGlow" />
          <feMergeNode in="SourceGraphic" />
        </feMerge>
      </filter>
      <filter
        id="subtleTaglineGlow"
        x="-30%"
        y="-30%"
        width="160%"
        height="160%"
      >
        <feGaussianBlur stdDeviation="2" result="softGlow" />
        <feMerge>
          <feMergeNode in="softGlow" />
          <feMergeNode in="SourceGraphic" />
        </feMerge>
      </filter>
      <linearGradient id="finalTextGradient" x1="0%" y1="0%" x2="0%" y2="100%">
        <stop offset="0%" stopColor="#ffffff" />
        <stop offset="30%" stopColor="#b3e0ff" />
        <stop offset="70%" stopColor="#00d4ff" />
        <stop offset="100%" stopColor="#0099cc" />
      </linearGradient>
      <linearGradient id="taglineGradient" x1="0%" y1="0%" x2="0%" y2="100%">
        <stop offset="0%" stopColor="#87ceeb" />
        <stop offset="50%" stopColor="#5bb3d9" />
        <stop offset="100%" stopColor="#3399cc" />
      </linearGradient>
      {/* Subtle pulsing animation */}
      <animate
        id="pulse"
        attributeName="opacity"
        values="0.8;1;0.8"
        dur="3s"
        repeatCount="indefinite"
      />
    </defs>
    <rect width="100%" height="100%" fill="#000000" />

    {/* Main title with professional glow */}
    <text
      x="512"
      y="460"
      fontFamily="'Segoe UI', -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif"
      fontSize="100"
      fontWeight="300"
      textAnchor="middle"
      fill="#00d4ff"
      opacity="0.6"
      filter="url(#professionalGlow)"
      letterSpacing="3px"
    >
      Sparkonics
      <animate
        attributeName="opacity"
        values="0.6;0.9;0.6"
        dur="4s"
        repeatCount="indefinite"
      />
    </text>

    {/* Main text overlay */}
    <text
      x="512"
      y="460"
      fontFamily="'Segoe UI', -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif"
      fontSize="100"
      fontWeight="300"
      textAnchor="middle"
      fill="url(#finalTextGradient)"
      letterSpacing="3px"
    >
      Sparkonics
    </text>

    {/* Professional tagline, only if showTagline is true */}
    {showTagline && (
      <text
        x="512"
        y="540"
        fontFamily="'Segoe UI', -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif"
        fontSize="24"
        fontWeight="300"
        textAnchor="middle"
        fill="url(#taglineGradient)"
        filter="url(#subtleTaglineGlow)"
        letterSpacing="4px"
        opacity="0.9"
      >
        SOCIETY OF ELECTRICAL ENGINEERS
      </text>
    )}

    {/* Subtle loading indicator dots */}
    <g opacity="0.7">
      <circle cx="412" cy="600" r="2" fill="#00d4ff">
        <animate
          attributeName="opacity"
          values="0.3;1;0.3"
          dur="1.5s"
          repeatCount="indefinite"
          begin="0s"
        />
      </circle>
      <circle cx="437" cy="600" r="2" fill="#00d4ff">
        <animate
          attributeName="opacity"
          values="0.3;1;0.3"
          dur="1.5s"
          repeatCount="indefinite"
          begin="0.3s"
        />
      </circle>
      <circle cx="462" cy="600" r="2" fill="#00d4ff">
        <animate
          attributeName="opacity"
          values="0.3;1;0.3"
          dur="1.5s"
          repeatCount="indefinite"
          begin="0.6s"
        />
      </circle>
      <circle cx="487" cy="600" r="2" fill="#00d4ff">
        <animate
          attributeName="opacity"
          values="0.3;1;0.3"
          dur="1.5s"
          repeatCount="indefinite"
          begin="0.9s"
        />
      </circle>
      <circle cx="512" cy="600" r="2" fill="#00d4ff">
        <animate
          attributeName="opacity"
          values="0.3;1;0.3"
          dur="1.5s"
          repeatCount="indefinite"
          begin="1.2s"
        />
      </circle>
      <circle cx="537" cy="600" r="2" fill="#00d4ff">
        <animate
          attributeName="opacity"
          values="0.3;1;0.3"
          dur="1.5s"
          repeatCount="indefinite"
          begin="0.9s"
        />
      </circle>
      <circle cx="562" cy="600" r="2" fill="#00d4ff">
        <animate
          attributeName="opacity"
          values="0.3;1;0.3"
          dur="1.5s"
          repeatCount="indefinite"
          begin="0.6s"
        />
      </circle>
      <circle cx="587" cy="600" r="2" fill="#00d4ff">
        <animate
          attributeName="opacity"
          values="0.3;1;0.3"
          dur="1.5s"
          repeatCount="indefinite"
          begin="0.3s"
        />
      </circle>
      <circle cx="612" cy="600" r="2" fill="#00d4ff">
        <animate
          attributeName="opacity"
          values="0.3;1;0.3"
          dur="1.5s"
          repeatCount="indefinite"
          begin="0s"
        />
      </circle>
    </g>
  </svg>
);

const BLINK_COUNT = 8; // 4 complete blink cycles
const BLINK_DURATION = 250; // Faster, more dynamic blinking
const FINAL_TAGLINE_DURATION = 1000; // Tagline visible for at least 1s
const FINAL_LOGO_DURATION = 1000; // Logo only (optional fade out or hold)

export default function Loading() {
  const [stage, setStage] = useState(0);

  useEffect(() => {
    if (stage < BLINK_COUNT) {
      const timer = setTimeout(() => setStage(stage + 1), BLINK_DURATION);
      return () => clearTimeout(timer);
    } else if (stage === BLINK_COUNT) {
      // Show logo + tagline for at least 1s
      const timer = setTimeout(
        () => setStage(stage + 1),
        FINAL_TAGLINE_DURATION,
      );
      return () => clearTimeout(timer);
    } else if (stage === BLINK_COUNT + 1) {
      // Optionally: show logo only for another second (or fade out)
      const timer = setTimeout(() => setStage(stage + 1), FINAL_LOGO_DURATION);
      return () => clearTimeout(timer);
    }
  }, [stage]);

  let content;
  if (stage < BLINK_COUNT) {
    content = stage % 2 === 0 ? <SVG1 /> : <SVG2 />;
  } else if (stage === BLINK_COUNT) {
    // Show logo + tagline
    content = <SVG3 showTagline={true} />;
  } else if (stage === BLINK_COUNT + 1) {
    // Show logo only (no tagline)
    content = <SVG3 showTagline={false} />;
  } else {
    content = null;
  }

  return (
    <div
      style={{
        width: "100vw",
        height: "100vh",
        background: "#000000",
        position: "fixed",
        left: 0,
        top: 0,
        zIndex: 9999,
        overflow: "hidden",
        margin: 0,
        padding: 0,
      }}
    >
      {content}
    </div>
  );
}
