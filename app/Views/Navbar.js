
// Standalone Navbar Component - Just include this script and call createNavbar()

function createNavbar() {
  // Inject CSS styles first
  const styles = `
    <style id="navbar-styles">
      :root {
        --navbar-bg: rgb(1, 6, 15);
        --navbar-fg: rgb(144, 252, 253);
        --navbar-primary: rgb(246, 231, 82);
        --navbar-primary-alpha: rgba(246, 231, 82, 0.1);
        --navbar-border: rgba(144, 252, 253, 0.2);
        --navbar-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      }

      .sparkonics-navbar {
        background: linear-gradient(135deg, var(--navbar-bg) 0%, rgba(1, 6, 15, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--navbar-border);
        box-shadow: var(--navbar-shadow);
        position: sticky;
        top: 0;
        z-index: 1000;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      .sparkonics-navbar * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      .navbar-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 70px;
      }

      .navbar-logo {
        font-size: 1.8rem;
        font-weight: 700;
        letter-spacing: -0.02em;
      }

      .navbar-logo a {
        color: var(--navbar-primary);
        text-decoration: none;
        transition: all 0.3s ease;
        text-shadow: 0 2px 4px rgba(246, 231, 82, 0.3);
      }

      .navbar-logo a:hover {
        color: var(--navbar-fg);
        transform: scale(1.05);
      }

      .nav-links {
        display: flex;
        list-style: none;
        gap: 8px;
        align-items: center;
      }

      .nav-links li {
        position: relative;
      }

      .nav-links a {
        color: var(--navbar-fg);
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 500;
        font-size: 1rem;
        transition: all 0.3s ease;
        position: relative;
        display: block;
      }

      .nav-links a:hover {
        color: var(--navbar-primary);
        background: var(--navbar-primary-alpha);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(246, 231, 82, 0.2);
      }

      .nav-links a[aria-current="page"] {
        background: linear-gradient(135deg, var(--navbar-primary) 0%, rgba(246, 231, 82, 0.8) 100%);
        color: var(--navbar-bg);
        box-shadow: 0 4px 16px rgba(246, 231, 82, 0.3);
      }

      .nav-links a[aria-current="page"]:hover {
        background: var(--navbar-primary);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(246, 231, 82, 0.4);
      }

      .mobile-toggle {
        display: none;
        background: none;
        border: none;
        color: var(--navbar-primary);
        font-size: 1.5rem;
        cursor: pointer;
        padding: 8px;
        border-radius: 4px;
        transition: all 0.3s ease;
      }

      .mobile-toggle:hover {
        background: var(--navbar-primary-alpha);
        transform: scale(1.1);
      }

      .mobile-toggle.active {
        transform: rotate(90deg);
      }

      @media (max-width: 768px) {
        .mobile-toggle {
          display: block;
        }

        .nav-links {
          position: absolute;
          top: 100%;
          left: 0;
          right: 0;
          background: var(--navbar-bg);
          border-top: 1px solid var(--navbar-border);
          flex-direction: column;
          gap: 0;
          padding: 20px;
          box-shadow: var(--navbar-shadow);
          transform: translateY(-100%);
          opacity: 0;
          visibility: hidden;
          transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .nav-links.mobile-open {
          transform: translateY(0);
          opacity: 1;
          visibility: visible;
        }

        .nav-links li {
          width: 100%;
        }

        .nav-links a {
          display: block;
          width: 100%;
          text-align: center;
          padding: 15px 20px;
          margin: 5px 0;
          border-radius: 12px;
          font-size: 1.1rem;
        }

        .navbar-container {
          padding: 0 15px;
        }

        .navbar-logo {
          font-size: 1.6rem;
        }
      }

      @media (max-width: 480px) {
        .navbar-container {
          height: 60px;
          padding: 0 12px;
        }

        .navbar-logo {
          font-size: 1.4rem;
        }

        .nav-links {
          padding: 15px;
        }

        .nav-links a {
          padding: 12px 15px;
          font-size: 1rem;
        }
      }

      /* Animation for page load */
      .sparkonics-navbar {
        animation: navbarSlideIn 0.5s ease-out;
      }

      @keyframes navbarSlideIn {
        from {
          transform: translateY(-100%);
          opacity: 0;
        }
        to {
          transform: translateY(0);
          opacity: 1;
        }
      }

      /* Smooth scroll padding adjustment for sticky navbar */
      html {
        scroll-padding-top: 80px;
      }
    </style>
  `;

  // Inject styles if not already present
  if (!document.getElementById('navbar-styles')) {
    document.head.insertAdjacentHTML('beforeend', styles);
  }

  // Create navbar HTML
  const navbarHTML = `
    <nav class="sparkonics-navbar">
      <div class="navbar-container">
        <div class="navbar-logo">
          <a href="/public/">Sparkonics</a>
        </div>
        
        <button class="mobile-toggle" onclick="toggleMobileNav()" aria-label="Toggle navigation">
          ☰
        </button>
        
        <ul class="nav-links" id="navLinks">
          <li><a href="/client/home">Home</a></li>
          <li><a href="/client/dashboard">Dashboard</a></li>
          <li><a href="/quiz/leaderboard">LeaderBoard</a></li>
          <li><a href="/client/">Login</a></li>
        </ul>
      </div>
    </nav>
  `;

  // Insert navbar at the beginning of body
  document.body.insertAdjacentHTML('afterbegin', navbarHTML);

  // Add JavaScript functionality
  window.toggleMobileNav = function() {
    const navLinks = document.getElementById('navLinks');
    const mobileToggle = document.querySelector('.mobile-toggle');
    
    navLinks.classList.toggle('mobile-open');
    mobileToggle.classList.toggle('active');
  };

  // Close mobile nav when clicking on a link
  document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
      const navLinks = document.getElementById('navLinks');
      const mobileToggle = document.querySelector('.mobile-toggle');
      
      navLinks.classList.remove('mobile-open');
      mobileToggle.classList.remove('active');
    });
  });

  // Close mobile nav when clicking outside
  document.addEventListener('click', function(event) {
    const navbar = document.querySelector('.sparkonics-navbar');
    const navLinks = document.getElementById('navLinks');
    const mobileToggle = document.querySelector('.mobile-toggle');
    
    if (!navbar.contains(event.target) && navLinks.classList.contains('mobile-open')) {
      navLinks.classList.remove('mobile-open');
      mobileToggle.classList.remove('active');
    }
  });

  // Close mobile nav on window resize
  window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
      const navLinks = document.getElementById('navLinks');
      const mobileToggle = document.querySelector('.mobile-toggle');
      
      navLinks.classList.remove('mobile-open');
      mobileToggle.classList.remove('active');
    }
  });

  // Auto-highlight current page
  highlightCurrentPage();
}

// Function to highlight current page in navigation
function highlightCurrentPage() {
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll('.nav-links a');
  
  navLinks.forEach(link => {
    link.removeAttribute('aria-current');
    if (link.getAttribute('href') === currentPath) {
      link.setAttribute('aria-current', 'page');
    }
  });
}

// Auto-initialize if script is loaded after DOM content
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', createNavbar);
} else {
  // DOM is already loaded
  createNavbar();
}

// Export for manual initialization
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { createNavbar };
}
