// vite.config.js
import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import path from "path";

export default defineConfig({
  plugins: [react()],
  build: {
    lib: {
      entry: path.resolve("src/navbar-widget.jsx"), // or main.jsx if that’s what you're using
      name: "NavbarWidget",
      fileName: "navbar-widget",
      formats: ["iife"],
    },
    rollupOptions: {
      output: {
        globals: {
          react: "React",
          "react-dom": "ReactDOM",
        },
      },
    },
  },
  define: {
    "process.env": {}, // Fix for "process is not defined"
  },
});
