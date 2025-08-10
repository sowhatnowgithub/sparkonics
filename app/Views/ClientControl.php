<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Clients List</title>

  <?php echo "<style>" . Sowhatnow\App\Views\NavBar::$STYLE . "</style>"; ?>
  <style>
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
      border-radius: 0 0 8px 8px;
      margin-bottom: 30px;
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
    }

    .navbar button:hover {
      border-color: #FFD700;
      background-color: #FFD700;
      color: #003366;
    }

    /* Table Styles */
    table {
      border-collapse: collapse;
      width: 90%;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    th, td {
      border: 1px solid #ccc;
      padding: 12px;
      text-align: left;
    }

    th {
      background-color: #003366;
      color: #FFD700;
    }

    tr:nth-child(even) {
      background-color: #f2f9ff;
    }

    /* Delete Button */
    .delete-btn {
      background-color: #FFD700;
      color: #003366;
      border: none;
      padding: 8px 16px;
      font-weight: bold;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .delete-btn:hover {
      background-color: #e6c200;
    }

    h1 {
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <?php echo Sowhatnow\App\Views\NavBar::$NAVBAR; ?>
  <div class="navbar">
    <button onclick="fetchClients()">Refresh Clients</button>
  </div>

  <h1>Clients List</h1>

  <table id="clientsTable">
    <thead>
      <tr>
        <th>ClientId</th>
        <th>ClientName</th>
        <th>ClientWebMail</th>
        <th>ClientMobile</th>
        <th>ClientDegree</th>
        <th>ClientRollNo</th>
        <th>ClientPassword</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Data rows will be populated here -->
    </tbody>
  </table>

  <script>
    const apiBase = 'https://sparkonics.iitp.ac.in/client';

    async function fetchClients() {
      try {
        const response = await fetch(`${apiBase}/getclients`);
        if (!response.ok) throw new Error('Failed to fetch clients');
        const clients = await response.json();
        populateTable(clients);
      } catch (err) {
        alert('Error loading clients: ' + err.message);
      }
    }

    function populateTable(clients) {
      const tbody = document.querySelector('#clientsTable tbody');
      tbody.innerHTML = ''; // Clear old rows

      clients.forEach(client => {
        const tr = document.createElement('tr');

        tr.innerHTML = `
          <td>${client.ClientId}</td>
          <td>${client.ClientName}</td>
          <td>${client.ClientWebMail}</td>
          <td>${client.ClientMobile}</td>
          <td>${client.ClientDegree}</td>
          <td>${client.ClientRollNo}</td>
          <td>${client.ClientPassword}</td>
          <td><button class="delete-btn" data-id="${client.ClientId}">Delete</button></td>
        `;

        tbody.appendChild(tr);
      });

      // Attach delete event
      tbody.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = btn.getAttribute('data-id');
          if (confirm(`Are you sure you want to delete ClientId ${id}?`)) {
            deleteClient(id);
          }
        });
      });
    }

    async function deleteClient(clientId) {
      try {
        const response = await fetch(`${apiBase}/delete`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `ClientId=${encodeURIComponent(clientId)}`
        });

        if (!response.ok) throw new Error('Failed to delete client');
        alert('Client deleted successfully');
        fetchClients(); // Refresh after delete
      } catch (err) {
        alert('Error deleting client: ' + err.message);
      }
    }

    // Initial load
    fetchClients();
  </script>

</body>
</html>


