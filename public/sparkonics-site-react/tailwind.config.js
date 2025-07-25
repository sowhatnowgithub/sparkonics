/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,jsx,ts,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: 'rgb(1, 6, 15)',
        secondary: 'rgb(144, 252, 253)',
        tertiary: 'rgb(246, 231, 82)',
        white: 'rgb(255, 255, 255)',
      },
      fontFamily: {
        orbitron: ["'Orbitron'", 'sans-serif'],
      },
    },
  },
  plugins: [],
}

