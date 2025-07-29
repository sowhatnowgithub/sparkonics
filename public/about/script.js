// Header Static Background (no animation)
class HeaderBackground {
  constructor() {
    this.canvas = document.getElementById("headerCanvas");
    this.ctx = this.canvas.getContext("2d");
    this.resizeCanvas();
    this.drawStaticBackground();

    window.addEventListener("resize", () => {
      this.resizeCanvas();
      this.drawStaticBackground();
    });
  }

  resizeCanvas() {
    const header = this.canvas.parentElement;
    this.canvas.width = header.offsetWidth;
    this.canvas.height = header.offsetHeight;
  }

  drawStaticBackground() {
    this.ctx.fillStyle = "#01060F"; // static background color
    this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
  }
}

// Letter Glitch Static Background (no animation)
class LetterGlitch {
  constructor() {
    this.canvas = document.getElementById("canvas");
    this.ctx = this.canvas.getContext("2d");
    this.fontSize = 16;
    this.charWidth = 10;
    this.charHeight = 20;
    this.lettersAndSymbols = ["A", "B", "C", "D", "E", "F", "G", "H"];

    this.resize();
    this.drawStaticLetters();

    window.addEventListener("resize", () => {
      this.resize();
      this.drawStaticLetters();
    });
  }

  getRandomChar() {
    return this.lettersAndSymbols[
      Math.floor(Math.random() * this.lettersAndSymbols.length)
    ];
  }

  resize() {
    this.canvas.width = window.innerWidth;
    this.canvas.height = window.innerHeight;
    this.columns = Math.ceil(this.canvas.width / this.charWidth);
    this.rows = Math.ceil(this.canvas.height / this.charHeight);
  }

  drawStaticLetters() {
    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    this.ctx.font = `${this.fontSize}px monospace`;
    this.ctx.textBaseline = "top";
    this.ctx.fillStyle = "rgba(144, 252, 253, 0.3)";

    for (let row = 0; row < this.rows; row++) {
      for (let col = 0; col < this.columns; col++) {
        const x = col * this.charWidth;
        const y = row * this.charHeight;
        this.ctx.fillText(this.getRandomChar(), x, y);
      }
    }
  }
}

// Scroll Animations - disabled
class ScrollAnimations {
  constructor() {
    // Just make everything visible by default
    document.querySelectorAll("section").forEach((section) => {
      section.classList.add("visible");
    });

    this.setupScrollProgress(); // Optional: Keep if you want scroll bar indicator
  }

  setupScrollProgress() {
    const scrollIndicator = document.getElementById("scrollIndicator");
    if (!scrollIndicator) return;

    window.addEventListener("scroll", () => {
      const winScroll =
        document.body.scrollTop || document.documentElement.scrollTop;
      const height =
        document.documentElement.scrollHeight -
        document.documentElement.clientHeight;
      const scrolled = (winScroll / height) * 100;
      scrollIndicator.style.width = scrolled + "%";
    });
  }
}

// Smooth scrolling - disabled
function setupSmoothScrolling() {
  // Do nothing (disables smooth scroll)
}

// Initialize everything when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  new LetterGlitch(); // static
  new HeaderBackground(); // static
  new ScrollAnimations();

  setupSmoothScrolling();

  // Immediate appearance without animation
  const header = document.querySelector("header");
  if (header) {
    header.style.opacity = "1";
    header.style.transform = "none";
    header.style.transition = "none";
  }
});
