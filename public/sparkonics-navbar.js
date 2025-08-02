(function () {
  const style = document.createElement("style");
  style.innerHTML = `
    /* Reset and base styles */
    #snx-nav * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Main navbar container */
    #snx-nav {
      position: fixed;
      top: 16px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 9999;
      padding: 12px 20px;
      border-radius: 12px;
      background: rgba(1, 6, 15, 0.95);
      backdrop-filter: blur(10px);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      max-width: calc(100vw - 32px);
      width: auto;
    }

    /* Main navigation list */
    #snx-nav .snx-nav-list {
      display: flex;
      align-items: center;
      gap: 20px;
      list-style: none;
      margin: 0;
      padding: 0;
      color: rgb(246, 231, 82);
      font-weight: 500;
      font-size: 14px;
    }

    /* Logo styles - text with star */
    #snx-nav .snx-logo {
      display: flex;
      align-items: center;
      text-decoration: none;
      padding: 8px 16px;
      margin-right: 20px;
      transition: all 0.2s ease;
      gap: 8px;
    }

    #snx-nav .snx-logo:hover {
      transform: translateY(-1px);
    }

    #snx-nav .snx-logo-star {
      font-size: 24px;
      color: rgb(144, 252, 253);
      animation: sparkle 2s ease-in-out infinite;
    }

    #snx-nav .snx-logo-text {
      font-size: 20px;
      font-weight: 700;
      color: rgb(246, 231, 82);
      letter-spacing: 0.5px;
    }

    @keyframes sparkle {
      0%, 100% { transform: scale(1) rotate(0deg); }
      50% { transform: scale(1.1) rotate(180deg); }
    }

    /* Navigation links */
    #snx-nav a:not(.snx-logo) {
      text-decoration: none;
      color: rgb(246, 231, 82);
      transition: color 0.2s ease;
      padding: 6px 12px;
      border-radius: 6px;
      white-space: nowrap;
    }

    #snx-nav a:not(.snx-logo):hover {
      color: rgb(144, 252, 253);
      background: rgba(144, 252, 253, 0.1);
    }

    /* Dropdown styles */
    #snx-nav .snx-dropdown {
      position: relative;
    }

    #snx-nav .snx-dropdown-label {
      cursor: pointer;
      padding: 6px 12px;
      border-radius: 6px;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    #snx-nav .snx-dropdown-label:after {
      content: '▾';
      font-size: 10px;
      transition: transform 0.2s ease;
    }

    #snx-nav .snx-dropdown-label:hover {
      color: rgb(144, 252, 253);
      background: rgba(144, 252, 253, 0.1);
    }

    #snx-nav .snx-dropdown-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      margin-top: 4px;
      background: rgba(1, 6, 15, 0.98);
      padding: 8px;
      border-radius: 8px;
      border: 1px solid rgba(144, 252, 253, 0.3);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      min-width: 140px;
      backdrop-filter: blur(10px);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.2s ease;
    }

    #snx-nav .snx-dropdown:hover .snx-dropdown-menu,
    #snx-nav .snx-dropdown-menu:hover {
      display: block;
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    #snx-nav .snx-dropdown:hover .snx-dropdown-label:after,
    #snx-nav .snx-dropdown-menu:hover ~ .snx-dropdown-label:after {
      transform: rotate(180deg);
    }

    /* Create a bridge between dropdown trigger and menu */
    #snx-nav .snx-dropdown::before {
      content: '';
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      height: 4px;
      background: transparent;
    }

    #snx-nav .snx-dropdown-menu li {
      margin-bottom: 4px;
    }

    #snx-nav .snx-dropdown-menu li:last-child {
      margin-bottom: 0;
    }

    #snx-nav .snx-dropdown-menu a {
      display: block;
      padding: 8px 12px;
      font-size: 13px;
    }

    /* Mobile hamburger button */
    #snx-nav .snx-mobile-toggle {
      display: none;
      background: none;
      border: none;
      color: rgb(246, 231, 82);
      font-size: 18px;
      cursor: pointer;
      padding: 8px;
      border-radius: 4px;
      transition: all 0.2s ease;
      position: absolute;
      right: 8px;
      top: 50%;
      transform: translateY(-50%);
      z-index: 10001;
    }

    #snx-nav .snx-mobile-toggle:hover {
      color: rgb(144, 252, 253);
      background: rgba(144, 252, 253, 0.1);
    }

    /* Mobile container for logo and toggle */
    #snx-nav .snx-mobile-header {
      display: none;
      justify-content: center;
      align-items: center;
      width: 100%;
      position: relative;
      min-height: 52px;
    }

    /* Mobile logo (text with star) */
    #snx-nav .snx-mobile-logo {
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      padding: 8px 16px;
      transition: all 0.2s ease;
      z-index: 10000;
      gap: 6px;
    }

    #snx-nav .snx-mobile-logo:hover {
      transform: translateY(-1px);
    }

    #snx-nav .snx-mobile-logo .snx-logo-star {
      font-size: 20px;
      color: rgb(144, 252, 253);
      animation: sparkle 2s ease-in-out infinite;
    }

    #snx-nav .snx-mobile-logo .snx-logo-text {
      font-size: 18px;
      font-weight: 700;
      color: rgb(246, 231, 82);
      letter-spacing: 0.5px;
    }

    /* Mobile styles */
    @media (max-width: 768px) {
      #snx-nav {
        top: 8px;
        padding: 8px 16px;
        width: calc(100vw - 16px);
        max-width: none;
      }

      #snx-nav .snx-mobile-header {
        display: flex;
      }

      #snx-nav .snx-mobile-toggle {
        display: block;
      }

      #snx-nav .snx-nav-list {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        margin-top: 8px;
        background: rgba(1, 6, 15, 0.98);
        border-radius: 8px;
        border: 1px solid rgba(144, 252, 253, 0.3);
        padding: 12px;
        flex-direction: column;
        gap: 8px;
        align-items: stretch;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
      }

      #snx-nav .snx-nav-list.open {
        display: flex;
      }

      #snx-nav .snx-nav-list li {
        width: 100%;
      }

      #snx-nav a:not(.snx-logo):not(.snx-mobile-logo) {
        display: block;
        text-align: center;
        padding: 10px 16px;
        font-size: 15px;
      }

      /* Hide desktop logo in mobile */
      #snx-nav .snx-logo {
        display: none;
      }

      /* Mobile dropdown adjustments */
      #snx-nav .snx-dropdown-label {
        display: block;
        text-align: center;
        padding: 10px 16px;
      }

      #snx-nav .snx-dropdown-menu {
        position: static;
        display: none;
        margin-top: 4px;
        box-shadow: none;
        background: rgba(1, 6, 15, 0.8);
        opacity: 1;
        visibility: visible;
        transform: none;
        transition: none;
      }

      #snx-nav .snx-dropdown.mobile-open .snx-dropdown-menu {
        display: block !important;
      }

      #snx-nav .snx-dropdown.mobile-open .snx-dropdown-label:after {
        transform: rotate(180deg);
      }

      /* Disable hover on mobile and use click-based system */
      #snx-nav .snx-dropdown:hover .snx-dropdown-menu,
      #snx-nav .snx-dropdown-menu:hover {
        display: none !important;
        opacity: 0;
        visibility: hidden;
      }

      /* Override hover states on mobile */
      #snx-nav .snx-dropdown.mobile-open:hover .snx-dropdown-menu {
        display: block !important;
        opacity: 1;
        visibility: visible;
      }
    }

    /* Smaller mobile devices */
    @media (max-width: 480px) {
      #snx-nav {
        font-size: 13px;
      }

      #snx-nav a:not(.snx-logo):not(.snx-mobile-logo) {
        font-size: 14px;
        padding: 8px 12px;
      }

      #snx-nav .snx-mobile-logo .snx-logo-star {
        font-size: 18px;
      }

      #snx-nav .snx-mobile-logo .snx-logo-text {
        font-size: 16px;
      }
    }
  `;

  document.head.appendChild(style);

  const navbar = document.createElement("nav");
  navbar.id = "snx-nav";
  navbar.innerHTML = `
    <!-- Mobile header with centered text logo and toggle -->
    <div class="snx-mobile-header">
      <a href="/public/" class="snx-mobile-logo">
        <span class="snx-logo-star">⭐</span>
        <span class="snx-logo-text">Sparkonics</span>
      </a>
      <button class="snx-mobile-toggle" aria-label="Toggle navigation">☰</button>
    </div>

    <!-- Desktop navigation with left-aligned text logo -->
    <ul class="snx-nav-list">
      <!-- Text Logo on the left for Desktop (acts as home) -->
      <li>
        <a href="/public/" class="snx-logo">
          <span class="snx-logo-star">⭐</span>
          <span class="snx-logo-text">Sparkonics</span>
        </a>
      </li>

      <li><a href="/public/about">About</a></li>
      <li><a href="/public/events">Events</a></li>
      <li class="snx-dropdown">
        <span class="snx-dropdown-label">Resources</span>
        <ul class="snx-dropdown-menu">
          <li><a href="/public/oa">OA</a></li>
          <li><a href="/public/profs">Profs</a></li>
          <li><a href="/public/opp">Opportunities</a></li>
          <li><a href="/public/gallery">Projects</a></li>
          <li><a href="/thrds" target="_blank">Thrds</a></li>
        </ul>
      </li>
      <li><a href="/public/teams">Team</a></li>
    </ul>
  `;

  document.body.appendChild(navbar);

  // Mobile functionality
  const mobileToggle = navbar.querySelector(".snx-mobile-toggle");
  const navList = navbar.querySelector(".snx-nav-list");
  const dropdown = navbar.querySelector(".snx-dropdown");
  const dropdownLabel = navbar.querySelector(".snx-dropdown-label");

  // Toggle mobile menu
  mobileToggle.addEventListener("click", function () {
    navList.classList.toggle("open");
  });

  // Handle mobile dropdown
  dropdownLabel.addEventListener("click", function (e) {
    e.preventDefault(); // Always prevent default
    if (window.innerWidth <= 768) {
      dropdown.classList.toggle("mobile-open");
    }
  });

  // Add touch support for better mobile interaction
  dropdownLabel.addEventListener("touchend", function (e) {
    e.preventDefault();
    if (window.innerWidth <= 768) {
      dropdown.classList.toggle("mobile-open");
    }
  });

  // Add keyboard support for dropdown
  dropdownLabel.addEventListener("keydown", function (e) {
    if (e.key === "Enter" || e.key === " ") {
      e.preventDefault();
      if (window.innerWidth <= 768) {
        dropdown.classList.toggle("mobile-open");
      }
    }
  });

  // Improve focus management for desktop only
  dropdown.addEventListener("mouseenter", function () {
    if (window.innerWidth > 768) {
      dropdown.classList.add("desktop-hover");
    }
  });

  dropdown.addEventListener("mouseleave", function () {
    if (window.innerWidth > 768) {
      dropdown.classList.remove("desktop-hover");
    }
  });

  // Close mobile menu when clicking outside
  document.addEventListener("click", function (e) {
    if (!navbar.contains(e.target)) {
      navList.classList.remove("open");
      dropdown.classList.remove("mobile-open");
    }
  });

  // Close dropdown when clicking on a dropdown link
  const dropdownLinks = navbar.querySelectorAll(".snx-dropdown-menu a");
  dropdownLinks.forEach((link) => {
    link.addEventListener("click", function () {
      dropdown.classList.remove("mobile-open");
      navList.classList.remove("open");
    });
  });

  // Handle window resize
  window.addEventListener("resize", function () {
    if (window.innerWidth > 768) {
      navList.classList.remove("open");
      dropdown.classList.remove("mobile-open");
    }
  });
})();
