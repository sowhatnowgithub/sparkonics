
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <style>

    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f5f5f5;
    }
    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    label {
      display: block;
      margin: 15px 0 5px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="datetime-local"],
    input[type="url"],
    textarea {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f5f5f5;
    }
    .fancy-table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px auto;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      font-size: 16px;
    }

    .fancy-table th, .fancy-table td {
      border: 1px solid #ccc;
      padding: 12px 16px;
      text-align: left;
    }

    .fancy-table th {
      background-color: #007bff;
      color: #fff;
    }

    .summary-row {
      cursor: pointer;
      background-color: #f1f9ff;
    }

    .summary-row:hover {
      background-color: #e0f0ff;
    }

    .details-row td {
      background-color: #f9f9f9;
      font-family: monospace;
      white-space: pre-wrap;
      padding: 16px;
    }


    .navbar {
      display: flex;
      gap: 20px;
      background-color: #fff;
      padding: 10px 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 10px;
      justify-content: center;
    }

    .navbar button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
    }

    .subbar {
      display: none;
      justify-content: center;
      gap: 15px;
      margin-bottom: 20px;
    }

    .subbar button {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 4px;
      cursor: pointer;
    }

    #output {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      max-width: 800px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      white-space: pre-wrap;
      word-wrap: break-word;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <button onclick="handleNavClick('Events')">Events</button>
    <button onclick="handleNavClick('Profs')">Profs</button>
    <button onclick="handleNavClick('Images')">Images</button>
  </div>

  <div class="subbar" id="subbar">
    <button onclick="handleAction('Add')">Add</button>
    <button onclick="handleAction('Modify')">Modify</button>
    <button onclick="handleAction('Delete')">Delete</button>
    <button onclick="handleAction('Fetch')">Fetch</button>
  </div>

  <div id="output">Click a section to begin.</div>

  <script>
    let currentSection = "";
    const baseUrl = "<?php echo Sowhatnow\Env::API_BASE_URL; ?>";

    function handleNavClick(section) {
      currentSection = section;
      document.getElementById("subbar").style.display = "flex";
      const endpoint = `${baseUrl}/api/${section.toLowerCase()}`;

      fetch(endpoint, {
        method: "GET", // or "POST", depending on your use case
        headers: {
          "Authorization": "ApiKey public_secret_api_key"
        }
      })
        .then((response) => {
          const contentType = response.headers.get("Content-Type");
          if (contentType && contentType.includes("application/json")) {
            return response.json();
          } else {
            return response.text(); // fallback if it's not JSON
          }
        })
        .then((data) => {
          if (Array.isArray(data)) {
            document.getElementById("output").innerHTML = generateExpandableTable(data);
          } else {
            document.getElementById("output").textContent = JSON.stringify(data, null, 2);
          }
        })
        .catch((error) => {
          document.getElementById("output").textContent = `Error fetching ${section.toLowerCase()}: ` + error;
        });
    }
    function generateExpandableTable(data) {
      if (data.length === 0) return "<p>No data available.</p>";

      let keys = Object.keys(data[0]);
      let times = 3;
      let table = `<table class="fancy-table"><thead><tr>`;
      keys.forEach(key => {
        if(times <= 0) return;
        table += `<th>${key}</th>`
        times--;
        });
      table += `</tr></thead><tbody>`;
      data.forEach((item, index) => {
        let times = 3;

        table += `<tr class="summary-row" onclick="toggleDetails(${index})">`;
        keys.forEach(key => {
          if (times <= 0) return; // Stop after 2
          table += `<td>${item[key]}</td>`
          times--;
        });
        table += `</tr>`;

        table += `<tr class="details-row" id="details-${index}" style="display: none;"><td colspan="${keys.length}">
                    <pre>${JSON.stringify(item, null, 2)}</pre>
                  </td></tr>`;

      });

      table += `</tbody></table>`;
      return table;
    }

    function toggleDetails(index) {
      const row = document.getElementById(`details-${index}`);
      row.style.display = (row.style.display === "none") ? "table-row" : "none";
    }


    function handleAction(action) {
      if (!currentSection) {
        alert("Please select a section (Events or Profs) first.");
        return;
      }

      const formData = new FormData();
      formData.append("section", currentSection);
      formData.append("action", action);


    <?php
    $url = Sowhatnow\Env::HOST_ADDRESS;
    echo "fetch('$url/admin/getform', {
        method: 'POST',
        body: formData,
      })
        .then((response) => response.text()) // expecting PHP HTML/text response
        .then((text) => {
          document.getElementById('output').innerHTML = text;
        })
        .catch((error) => {
          document.getElementById('output').textContent = 'Error: ' + error;
        });
    }";
    ?>
  </script>

</body>
</html>
