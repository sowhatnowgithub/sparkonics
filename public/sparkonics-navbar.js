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
      border: 1px solid rgba(144, 252, 253, 0.3);
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

    /* Navigation links */
    #snx-nav a {
      text-decoration: none;
      color: rgb(246, 231, 82);
      transition: color 0.2s ease;
      padding: 6px 12px;
      border-radius: 6px;
      white-space: nowrap;
    }

    #snx-nav a:hover {
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
    }

    #snx-nav .snx-mobile-toggle:hover {
      color: rgb(144, 252, 253);
      background: rgba(144, 252, 253, 0.1);
    }

    /* Mobile styles */
    @media (max-width: 768px) {
      #snx-nav {
        top: 8px;
        padding: 8px 16px;
        width: calc(100vw - 16px);
        max-width: none;
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

      #snx-nav a {
        display: block;
        text-align: center;
        padding: 10px 16px;
        font-size: 15px;
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
        border: 1px solid rgba(144, 252, 253, 0.2);
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

      #snx-nav a {
        font-size: 14px;
        padding: 8px 12px;
      }
    }
  `;

  document.head.appendChild(style);

  const navbar = document.createElement("nav");
  navbar.id = "snx-nav";
  navbar.innerHTML = `
    <button class="snx-mobile-toggle" aria-label="Toggle navigation">☰</button>
    <ul class="snx-nav-list">
      <li><a href="/">Home</a></li>
      <li><a href="/about">About</a></li>
      <li><a href="/events">Events</a></li>
      <li class="snx-dropdown">
        <span class="snx-dropdown-label">Resources</span>
        <ul class="snx-dropdown-menu">
          <li><a href="/oa">OA</a></li>
          <li><a href="/profs">Profs</a></li>
          <li><a href="/opp">Opportunities</a></li>
          <li><a href="/gallery">Projects</a></li>
          <li><a href="/thrds" target="_blank">Thrds</a></li>
        </ul>
      </li>
      <li><a href="/teams">Team</a></li>
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
