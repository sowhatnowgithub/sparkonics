<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Website Control</title>
  <style>
    /* General Styles */
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f7f7f7;
    }

    /* Navigation Bar */
    .navbar {
      display: flex;
      justify-content: center;
      gap: 20px;
      background-color: #333;
      padding: 15px 0;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      border-radius: 8px 8px 0 0;
    }

    .navbar button {
      background-color: transparent;
      color: #fff;
      border: none;
      padding: 12px 25px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease, color 0.3s ease;
      border-radius: 4px;
    }

    .navbar button:hover {
      background-color: #444;
      color: #ffffff;
    }

    .navbar button.active {
      background-color: #555;
      color: #ffffff;
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
  </style>
</head>
<body>

  <!-- Navigation Bar -->
  <div class="navbar">
    <a href="/admin/dashboard">
      <button>Dashboard</button>
    </a>
    <a href="/admin/members">
      <button>Members</button>
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
  </div>

  <!-- Content Area (Placeholder for now) -->
  <div class="content" id="content-area">
    <h2>Welcome to the Website Control Portal!</h2>
    <p>Select a section from the navbar above to navigate.</p>
  </div>

</body>
</html>
