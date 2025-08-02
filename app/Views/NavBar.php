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
        gap: 20px;
        background-color: #003366; /* Dark Blue */
        padding: 15px 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        border-radius: 8px 8px 0 0;
      }

      .navbar button {
        background-color: transparent;
        color: #FFD700; /* Gold */
        border: 2px solid transparent;
        padding: 12px 25px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        border-radius: 4px;
      }

      .navbar button:hover {
        background-color: #FFD700;
        color: #003366;
        border-color: #FFD700;
      }

      .navbar button.active {
        background-color: #FFD700;
        color: #003366;
      }

      /* Content Area */
      .content {
        padding: 30px;
        text-align: center;
      }

      /* Responsive Design */
      @media (max-width: 768px) {
        .navbar {
          flex-direction: column;
          align-items: center;
        }

        .navbar button {
          margin: 10px 0;
        }

        .content {
          padding: 20px;
        }
      }
    STYLE;

    public static $NAVBAR = <<<'NAVBAR'
    <!-- Navigation Bar -->
    <div class="navbar">
      <a href="/admin/dashboard">
        <button>Dashboard</button>
      </a>
      <a href="/admin/members">
        <button>Members Control</button>
      </a>
      <a href="/admin/websitecontrol">
        <button>Website Control</button>
      </a>
      <a href="/admin/log">
        <button>log</button>
      </a>
      <a href="/admin/logout">
        <button>Logout</button>
      </a>
      <a href="/admin/scheduler">
        <button>Scheduler</button>
      </a>
    </div>
    NAVBAR;
}
