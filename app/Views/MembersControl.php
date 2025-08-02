<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Members Control</title>
  <?php echo "<style>" .
      Sowhatnow\App\Views\NavBar::$STYLE .
      "
      .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 24px;
        padding: 20px;
      }

      .member-card {
        background-color: #ffffff;
        border: 2px solid #003366;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        transition: transform 0.2s ease;
      }

      .member-card:hover {
        transform: translateY(-6px);
      }

      .member-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 12px;
        border: 3px solid #FFD700;
      }

      .member-info h3 {
        margin: 0;
        font-size: 18px;
        color: #003366;
      }

      .member-info .position {
        font-weight: bold;
        color: #FFD700;
        margin: 4px 0;
      }

      .member-info p {
        font-size: 14px;
        margin: 2px 0;
        color: #003366;
      }

      .member-info a {
        color: #003366;
        text-decoration: none;
      }

      .member-info a:hover {
        text-decoration: underline;
      }

      .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999;
      }

      .hidden {
        display: none;
      }

      .modal-content {
        background: #ffffff;
        color: #003366;
        padding: 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
        text-align: center;
        position: relative;
        box-shadow: 0 4px 16px rgba(0,0,0,0.3);
      }

      .close {
        position: absolute;
        right: 16px;
        top: 10px;
        font-size: 24px;
        cursor: pointer;
        color: #003366;
      }

      .modal-img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
        border: 3px solid #FFD700;
      }

      .access-btn {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 18px;
        background-color: #003366;
        color: #ffffff;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.2s;
      }

      .access-btn:hover {
        background-color: #002244;
      }

      .delete-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 16px;
        background-color: #cc0000;
        color: #ffffff;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.2s;
      }

      .delete-btn:hover {
        background-color: #a30000;
      }

      .gold-background {
        background-color: #FFD700 !important;
        color: #003366;
      }

      body {
        background-color: #e6f0ff; /* Light blue background */
      }
    </style>"; ?>

  <style>
    body {
      font-family: monospace;
      background-color: #282c34;
      color: #f8f8f2;
      padding: 20px;
    }
    pre {
      background-color: #1e1e1e;
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
      color: #61dafb;
    }
  </style>
</head>
<body>

    <?php echo Sowhatnow\App\Views\NavBar::$NAVBAR; ?>
    <a  href="<?php echo Sowhatnow\Env::HOST_ADDRESS .
        "/admin/backupdb"; ?>" alt="Download the Backup Databases" target="_blank"><h1>Download the backup dbs</h1></a>

    <div class="content" id="content-area">
      <h2>Members</h2>
      <div class="team-grid">
          <div class="member-card gold-background">
            <img src="<?php echo $url; ?>/api/images/4901" alt="Member Image" class="member-photo">
            <div class="member-info">
              <h3>Sowhatnow</h3>
              <p class="position">Position: 👑</p>
              <p>Role: <b>Adding Cat Pics</b></p>
              <p><strong>Email:</strong> sowhatnow@iitp.ac.in</p>
            </div>
          </div>

          <?php foreach ($membersData as $member): ?>
            <?php $memberJson = htmlspecialchars(
                json_encode($member),
                ENT_QUOTES,
                "UTF-8",
            ); ?>
            <div class="member-card" onclick='openModal(<?= $memberJson ?>)'>
              <img src="<?= htmlspecialchars(
                  $member["MemImageUrl"],
              ) ?>" alt="Member Image" class="member-photo">
              <div class="member-info">
                <h3><?= htmlspecialchars($member["MemName"]) ?></h3>
                <p class="position"><?= htmlspecialchars(
                    $member["MemPosition"],
                ) ?></p>
                <p><?= htmlspecialchars($member["MemDegree"]) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
      </div>
    </div>

    <div id="memberModal" class="modal hidden">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modal-img" src="" alt="Member Image" class="modal-img">
        <h2 id="modal-name"></h2>
        <p><strong>Email:</strong> <span id="modal-email"></span></p>
        <p><strong>Phone:</strong> <span id="modal-phone"></span></p>
        <p><strong>Roll No:</strong> <span id="modal-roll"></span></p>
        <p><strong>Degree:</strong> <span id="modal-degree"></span></p>
        <p><strong>Position:</strong> <span id="modal-position"></span></p>
        <p><strong>Role:</strong> <span id="modal-role"></span></p>

        <input type="text" id="update-role-input" placeholder="Enter new role" />

        <p><strong>Access Granted:</strong> <span id="modal-access"></span></p>
        <a id="access-toggle" class="access-btn" href="#">Toggle Access</a>
        <a id="delete-member" class="delete-btn" href="#">Delete Member</a>
        <button id="update-role-btn" class="access-btn">Update Role</button>

      </div>
    </div>

    <script>
    function openModal(member) {
        document.getElementById('memberModal').classList.remove('hidden');

        document.getElementById('modal-img').src = '<?php echo $url; ?>' + member.MemImageUrl;
        document.getElementById('modal-name').textContent = member.MemName;
        document.getElementById('modal-email').textContent = member.MemWebMail;
        document.getElementById('modal-phone').textContent = member.MemMobile;
        document.getElementById('modal-roll').textContent = member.MemRollNo;
        document.getElementById('modal-degree').textContent = member.MemDegree;
        document.getElementById('modal-position').textContent = member.MemPosition;
        document.getElementById('modal-role').textContent = member.MemRole;  // Displaying the role
        document.getElementById('update-role-input').value = member.MemRole;  // Pre-filling the role input field
        document.getElementById('modal-access').textContent = member.MemAccessGranted ? "Yes ✅" : "No ❌";

        // Toggle button for access
        const newAccess = member.MemAccessGranted ? 0 : 1;
        document.getElementById('access-toggle').onclick = function(e) {
            e.preventDefault();  // Prevent default behavior (i.e., navigation)

            const url = `<?php echo $url; ?>/admin/member/access`;
            const headers = new Headers();
            headers.append("Authorization", "AppKey <?php
            require "Authenticate.php";
            echo $appkey;
            ?>");
            headers.append("Content-Type","application/x-www-form-urlencoded");

            const data = new URLSearchParams();
            data.append("MemId", member.MemId);
            data.append("MemAccessGranted", newAccess);

	    console.log(newAccess);
	    console.log(url);
            fetch(url, {
                method: "POST",
                headers: headers,
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if (data.success == 'true') {
                    document.getElementById('modal-access').textContent = newAccess ? "Yes ✅" : "No ❌";
                    document.getElementById('access-toggle').textContent = newAccess ? "Revoke Access" : "Grant Access";
                } else {
			console.log(data);
                    alert("Failed to update access.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Error occurred while updating access.");
            });
        };

        // Delete button functionality
        document.getElementById('delete-member').onclick = function(e) {
            e.preventDefault();  // Prevent default behavior (i.e., navigation)

            const url = `<?php echo $url; ?>/admin/member/delete`;
            const headers = new Headers();
            headers.append("Authorization", "AppKey <?php
            require "Authenticate.php";
            echo $appkey;
            ?>");
            headers.append("Content-Type","application/x-www-form-urlencoded");

            const data = new URLSearchParams();
            data.append("MemId", member.MemId);

            fetch(url, {
                method: "POST",
                headers: headers,
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if (data.success != 'false') {
                    alert("Member deleted successfully.");
                    closeModal();
                    document.querySelector(`#member-${member.MemId}`).remove();
                } else {
                    alert("Failed to delete member.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Error occurred while deleting member.");
            });
        };

        // Update Role button functionality
        document.getElementById('update-role-btn').onclick = function(e) {
            e.preventDefault();  // Prevent default behavior (i.e., navigation)

            const newRole = document.getElementById('update-role-input').value;

            if (!newRole) {
                alert("Please enter a role.");
                return;
            }

            const url = `<?php echo $url; ?>/admin/member/updaterole`;
            const headers = new Headers();
            headers.append("Authorization", "AppKey <?php
            require "Authenticate.php";
            echo $appkey;
            ?>");
            headers.append("Content-Type", "application/x-www-form-urlencoded");

            const data = new URLSearchParams();
            data.append("MemId", member.MemId);
            data.append("MemRole", newRole);

            fetch(url, {
                method: "POST",
                headers: headers,
                body: data
            })
            .then(response => response.json())
            .then(data => {
                if (data.success == 'true') {
                    // Update the displayed role in the modal
                    document.getElementById('modal-role').textContent = newRole;
                    alert("Role updated successfully.");
                } else {
                    alert("Failed to update role.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Error occurred while updating the role.");
            });
        };
    }

        function closeModal() {
            // Hide the modal
            document.getElementById('memberModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('memberModal');
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>

</body>
</html>
