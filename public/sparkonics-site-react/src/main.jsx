import React from "react";
import { createRoot } from "react-dom/client";
import FuturisticNavbar from "./App";

window.injectNavbar = function (elementId = "react-navbar") {
  const container = document.getElementById(elementId);
  if (container) {
    const root = createRoot(container);
    root.render(<FuturisticNavbar />);
  } else {
    console.warn(`Element #${elementId} not found`);
  }
};
