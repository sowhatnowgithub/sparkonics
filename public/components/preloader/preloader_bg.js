// preloader.js
export function showAtomicPreloader({
  onComplete = () => {},
  blockSize = 65, // bigger blocks so symbols show clearly
  revealDelay = 2, // faster reveal
} = {}) {
  const preloader = document.createElement("div");
  preloader.id = "preloader";
  document.body.appendChild(preloader);

  const style = document.createElement("style");
  style.textContent = `
    :root {
      --primary: rgb(1, 6, 15);
      --secondary: rgb(144, 252, 253);
      --tertiary: rgb(246, 231, 82);
    }

    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      display: flex;
      flex-wrap: wrap;
      z-index: 1000;
      background-color:rgb(1, 6, 15);
      transition: transform 1s ease-in-out, opacity 1s ease-in-out;
    }

    .block {
      background-color: rgba(1, 6, 15, 0.4);
      opacity: 0;
      transform: scale(0.5);
      transition: all 0.3s ease;
      border: 1px solid rgba(144, 252, 253, 0.1);
      background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 50 50' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='25' cy='25' r='15' fill='%2390fcfd'/%3E%3Ctext x='25' y='30' font-family='Arial' font-size='24' fill='%23000000' text-anchor='middle'%3E-%3C/text%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: center;
      background-size: 40px 40px;
    }

    .block.is-visible {
      opacity: 0.2;
      transform: scale(1);
      background-color: rgba(144, 252, 253, 0.1);
    }

    .block.unified-pattern {
      background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 50 50' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='25' cy='25' r='15' fill='%23f6e752'/%3E%3Ctext x='25' y='30' font-family='Arial' font-size='24' fill='%23000000' text-anchor='middle'%3E+%3C/text%3E%3C/svg%3E");
      background-color: rgba(246, 231, 82, 0.2);
    }
  `;
  document.head.appendChild(style);

  const wait = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

  function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [array[i], array[j]] = [array[j], array[i]];
    }
  }

  function createBlockGrid() {
    const screenWidth = window.innerWidth;
    const screenHeight = window.innerHeight;
    const cols = Math.ceil(screenWidth / blockSize);
    const rows = Math.ceil(screenHeight / blockSize);

    const blocks = [];

    for (let row = 0; row < rows; row++) {
      for (let col = 0; col < cols; col++) {
        const block = document.createElement("div");
        block.classList.add("block");
        block.style.width = `${blockSize}px`;
        block.style.height = `${blockSize}px`;
        block.style.position = "absolute";
        block.style.left = `${col * blockSize}px`;
        block.style.top = `${row * blockSize}px`;
        preloader.appendChild(block);
        blocks.push(block);
      }
    }
    return blocks;
  }

  async function runAnimation() {
    const blocks = createBlockGrid();

    shuffle(blocks);
    for (const block of blocks) {
      block.classList.add("is-visible");
      await wait(revealDelay);
    }

    await wait(500); // electron phase hold

    for (const block of blocks) {
      block.classList.add("unified-pattern");
      await wait(1);
    }

    await wait(400); // proton phase hold

    preloader.style.transform = "translateY(-100%)";
    preloader.style.opacity = "0";

    await wait(800);
    preloader.remove();
    if (typeof onComplete === "function") onComplete();
  }

  runAnimation();
}
