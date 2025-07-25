// src/events-widget.jsx
import React from "react";
import { createRoot } from "react-dom/client";
import Events from "./components/pages/Events";

window.injectEventsWidget = function (elementId = "events-widget") {
  const container = document.getElementById(elementId);
  if (container) {
    const root = createRoot(container);
    root.render(<Events />);
  } else {
    console.warn(`Element #${elementId} not found`);
  }
};
