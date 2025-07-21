<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Website Control</title>
  <style>
  <?php echo Sowhatnow\App\Views\NavBar::$STYLE; ?>

  body {
    font-family: monospace;
    background-color: #282c34;
    color: #f8f8f2;
    padding: 20px;
  }
  pre {
    background-color: #003366;
    color: #FFD700;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    overflow: auto;
    white-space: pre-wrap;
    word-wrap: break-word;
    max-height: 600px;
    max-width: 100%;
  }

  h1 {
    color: #003366;
  }

  form {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    max-width: 500px;
    margin: auto;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    color: #003366;
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
    border: 1px solid #003366;
    border-radius: 4px;
  }

  input[type="submit"] {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #FFD700;
    color: #003366;
    border: none;
    border-radius: 4px;
    cursor: pointer;
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
    background-color: #003366;
    color: #FFD700;
  }

  .summary-row {
    cursor: pointer;
    background-color: #FFF8DC;
  }

  .summary-row:hover {
    background-color: #FFEFD5;
  }

  .details-row td {
    background-color: #003366;
    color: #FFD700;
    font-family: monospace;
    white-space: pre-wrap;
    padding: 16px;
  }

  .controlbar {
    display: flex;
    gap: 20px;
    background-color: #003366;
    padding: 10px 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    margin-bottom: 10px;
    justify-content: center;
  }

  .controlbar button {
    background-color: #FFD700;
    color: #003366;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
  }

  .controlbar button:hover {
    background-color: #e6c200;
  }

  .subbar {
    display: none;
    justify-content: center;
    gap: 15px;
    margin-bottom: 20px;
  }

  .subbar button {
    background-color: #003366;
    color: #FFD700;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
  }

  .subbar button:hover {
    background-color: #002244;
  }

  #output {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    max-width: 800px;
    margin: auto;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    white-space: pre-wrap;
    word-wrap: break-word;
    color: #003366;
  }
  </style>
</head>
<body>
    <?php echo Sowhatnow\App\Views\NavBar::$NAVBAR; ?>

  <div class="controlbar">
    <button onclick="handleNavClick('Events')">Events</button>
    <button onclick="handleNavClick('Profs')">Profs</button>
    <button onclick="handleNavClick('Images')">Images</button>
    <button onclick="handleNavClick('Gallery')">Gallery</button>
    <button onclick="handleNavClick('Team')">Team</button>
    <button onclick="handleNavClick('Opp')">Oppurtunity</button>

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

       const hostAddress = "<?php echo Sowhatnow\Env::HOST_ADDRESS; ?>";

       fetch(`${hostAddress}/admin/getform`, {
         method: 'POST',
         body: formData,
       })
         .then((response) => response.text())
         .then((html) => {
           document.getElementById('output').innerHTML = html;

           const form = document.querySelector('#output form');
           if (form) {
             form.addEventListener('submit', function (e) {
               e.preventDefault();

               const submissionData = new FormData(form);

               fetch(form.getAttribute('action') || window.location.href, {
                 method: form.getAttribute('method') || 'POST',
                 body: submissionData
               })
                 .then(response => {
                   const contentType = response.headers.get("Content-Type");

                   if (contentType.includes("application/json")) {
                     return response.json().then(data => {
                       document.getElementById("output").textContent = JSON.stringify(data, null, 2);
                     });
                   } else if (contentType.startsWith("image/")) {
                     return response.blob().then(imageBlob => {
                       const imageUrl = URL.createObjectURL(imageBlob);
                       document.getElementById("output").innerHTML = `<img src="${imageUrl}" style="max-width: 100%;" />`;
                     });
                   } else {
                     return response.text().then(text => {
                       document.getElementById("output").textContent = text;
                     });
                   }
                 })
                 .catch(error => {
                   document.getElementById("output").textContent = "Submission error: " + error;
                 });
             });

           }
         })
         .catch((error) => {
           document.getElementById('output').textContent = 'Error: ' + error;
         });
     }
  </script>

</body>
</html>
