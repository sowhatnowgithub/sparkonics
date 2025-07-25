import React from "react";
import { createRoot } from "react-dom/client";
import Navbar from "./App.jsx";
import "./App.css";
import "./index.css";
window.injectNavbar = function (elementId = "react-navbar") {
  const container = document.getElementById(elementId);
  if (container) {
    const root = createRoot(container);
    root.render(<Navbar />);
  } else {
    console.warn(`Element #${elementId} not found`);
  }
};
