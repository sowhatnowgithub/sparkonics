<?php
namespace Sowhatnow\App\Views;
class NavBar
{
    public static $STYLE = <<<'STYLE'
      /* General Styles */
      body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #ADD8E6; /* Light Blue */
        color: #003366;
      }
      
      /* Navigation Bar */
      .navbar {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        background-color: #003366; /* Dark Blue */
        padding: 15px 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        border-radius: 8px 8px 0 0;
        position: relative;
      }
      
      /* Mobile Menu Toggle */
      .mobile-toggle {
        display: none;
        background: none;
        border: none;
        color: #FFD700;
        font-size: 24px;
        cursor: pointer;
        padding: 5px;
      }
      
      /* Navigation Menu */
      .nav-menu {
        display: flex;
        align-items: center;
        gap: 15px;
        list-style: none;
        margin: 0;
        padding: 0;
      }
      
      /* Regular Navigation Buttons */
      .navbar .nav-btn {
        background-color: transparent;
        color: #FFD700; /* Gold */
        border: 2px solid transparent;
        padding: 12px 25px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 4px;
        text-decoration: none;
        display: inline-block;
      }
      
      .navbar .nav-btn:hover {
        background-color: #FFD700;
        color: #003366;
        border-color: #FFD700;
      }
      
      .navbar .nav-btn.active {
        background-color: #FFD700;
        color: #003366;
      }
      
      /* Dropdown Styles */
      .dropdown {
        position: relative;
        display: inline-block;
      }
      
      .dropdown-btn {
        background-color: transparent;
        color: #FFD700;
        border: 2px solid transparent;
        padding: 12px 25px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
      }
      
      .dropdown-btn:hover {
        background-color: #FFD700;
        color: #003366;
        border-color: #FFD700;
      }
      
      .dropdown-arrow {
        transition: transform 0.3s ease;
      }
      
      .dropdown.open .dropdown-arrow {
        transform: rotate(180deg);
      }
      
      .dropdown-content {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #003366;
        min-width: 180px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        z-index: 1000;
        border: 1px solid #FFD700;
      }
      
      .dropdown.open .dropdown-content {
        display: block;
      }
      
      .dropdown-content a {
        color: #FFD700;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        transition: background-color 0.3s ease;
        font-weight: 500;
      }
      
      .dropdown-content a:hover {
        background-color: #FFD700;
        color: #003366;
      }
      
      /* Content Area */
      .content {
        padding: 30px;
        text-align: center;
      }
      
      /* Mobile Responsive Design */
      @media (max-width: 768px) {
        .mobile-toggle {
          display: block;
        }
        
        .nav-menu {
          display: none;
          position: absolute;
          top: 100%;
          left: 0;
          right: 0;
          background-color: #003366;
          flex-direction: column;
          padding: 20px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
          border-radius: 0 0 8px 8px;
        }
        
        .nav-menu.mobile-open {
          display: flex;
        }
        
        .navbar .nav-btn {
          width: 100%;
          text-align: center;
          margin: 5px 0;
          padding: 15px 20px;
        }
        
        .dropdown-btn {
          width: 100%;
          text-align: center;
          justify-content: center;
          margin: 5px 0;
          padding: 15px 20px;
        }
        
        .dropdown-content {
          position: static;
          display: none;
          box-shadow: none;
          border: none;
          background-color: rgba(255, 215, 0, 0.1);
          margin-top: 10px;
          border-radius: 4px;
        }
        
        .dropdown.open .dropdown-content {
          display: block;
        }
        
        .content {
          padding: 20px;
        }
      }
    STYLE;

    public static $NAVBAR = <<<'NAVBAR'
    <!-- Navigation Bar -->
    <nav class="navbar">
      <!-- Mobile Toggle Button -->
      <button class="mobile-toggle" onclick="toggleMobileMenu()">☰</button>
      
      <!-- Navigation Menu -->
      <ul class="nav-menu" id="navMenu">
        <!-- Dashboard -->
        <li>
          <a href="/admin/dashboard" class="nav-btn">Dashboard</a>
        </li>
        
        <!-- Control Dropdown -->
        <li class="dropdown" id="controlDropdown">
          <button class="dropdown-btn" onclick="toggleDropdown('controlDropdown')">
            Control <span class="dropdown-arrow">▼</span>
          </button>
          <div class="dropdown-content">
            <a href="/admin/members">Members Control</a>
            <a href="/admin/websitecontrol">Website Control</a>
            <a href="/admin/client">Client Control</a>
            <a href="/admin/quiz">Quiz Control</a>
            <a href="/admin/quizquestion">QuizQuestion Control</a>
          </div>
        </li>
        
        <!-- Tools Dropdown -->
        <li class="dropdown" id="toolsDropdown">
          <button class="dropdown-btn" onclick="toggleDropdown('toolsDropdown')">
            Tools <span class="dropdown-arrow">▼</span>
          </button>
          <div class="dropdown-content">
            <a href="/admin/scheduler">Scheduler</a>
            <a href="/admin/log">Log</a>
          </div>
        </li>
        
        <!-- Logout -->
        <li>
          <a href="/admin/logout" class="nav-btn">Logout</a>
        </li>
      </ul>
    </nav>

    <script>
      function toggleMobileMenu() {
        const navMenu = document.getElementById('navMenu');
        navMenu.classList.toggle('mobile-open');
      }
      
      function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        
        // Close other dropdowns
        const allDropdowns = document.querySelectorAll('.dropdown');
        allDropdowns.forEach(d => {
          if (d.id !== dropdownId) {
            d.classList.remove('open');
          }
        });
        
        // Toggle current dropdown
        dropdown.classList.toggle('open');
      }
      
      // Close dropdowns when clicking outside
      document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dropdown');
        const isClickInsideDropdown = event.target.closest('.dropdown');
        
        if (!isClickInsideDropdown) {
          dropdowns.forEach(dropdown => {
            dropdown.classList.remove('open');
          });
        }
      });
      
      // Close mobile menu when window is resized to desktop
      window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
          document.getElementById('navMenu').classList.remove('mobile-open');
        }
      });
    </script>
    NAVBAR;
}
?>
