// vite.config.js
import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

export default defineConfig({
  plugins: [react()],
  define: {
    // Prevent process.env from breaking in browser builds
    "process.env": {},
  },
  build: {
    lib: {
      entry: "src/events-widget.jsx",
      name: "EventsWidget",
      fileName: () => "events-widget.iife.js",
      formats: ["iife"],
    },
    rollupOptions: {
      external: [],
      output: {
        globals: {
          react: "React",
          "react-dom": "ReactDOM",
        },
      },
    },
  },
});
