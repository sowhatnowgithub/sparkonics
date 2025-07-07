<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>

  <?php echo "<style>" . Sowhatnow\App\Views\NavBar::$STYLE . "</style>"; ?>

  <style>
    /* Base Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background-color: #f2f4f8;
      color: #333;
    }

    .content {
      max-width: 1100px;
      margin: 40px auto;
      padding: 30px;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    }

    .content h2 {
      font-size: 2rem;
      color: #2e7d32;
      margin-bottom: 10px;
    }

    .content p {
      color: #555;
      margin-bottom: 25px;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 30px;
      padding: 20px;
      background-color: #f9f9f9;
      border-radius: 10px;
      border: 1px solid #e0e0e0;
      margin-bottom: 30px;
    }

    .user-info img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #4caf50;
      background-color: #eee;
    }

    .user-info .details h3 {
      font-size: 1.5rem;
      color: #333;
      margin-bottom: 10px;
    }

    .user-info .details p {
      margin: 6px 0;
      font-size: 1rem;
      color: #666;
    }

    .info-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .info-card {
      background: #fcfcfc;
      padding: 20px;
      border-radius: 10px;
      border: 1px solid #e5e5e5;
      transition: box-shadow 0.2s ease;
    }

    .info-card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .info-card h4 {
      font-size: 1.2rem;
      color: #388e3c;
      margin-bottom: 12px;
    }

    .info-card p {
      font-size: 0.95rem;
      color: #555;
      line-height: 1.5;
    }

    .info-card p strong {
      color: #333;
    }
    .image-update button {
      padding: 10px 18px;
      background: linear-gradient(to right, #43a047, #66bb6a);
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 0.95rem;
      font-weight: 500;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    .image-update button:hover {
      background: linear-gradient(to right, #388e3c, #4caf50);
      transform: translateY(-2px);
    }

    @media (max-width: 600px) {
      .user-info {
        flex-direction: column;
        text-align: center;
        gap: 20px;
      }

      .user-info img {
        margin-bottom: 10px;
      }

      .user-info .details {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <?php echo Sowhatnow\App\Views\NavBar::$NAVBAR; ?>

  <div class="content" id="content-area">
    <h2>Welcome to the Website Dashboard Portal!</h2>
    <p>Your info</p>

    <div class="user-info">
      <img src="<?php echo $url .
          $memberData[0]["MemImageUrl"]; ?>" alt="User Image">
      <div class="details">
        <h3><?php echo $memberData[0]["MemName"]; ?></h3>
        <p><strong>Email:</strong> <?php echo $memberData[0][
            "MemWebMail"
        ]; ?></p>
        <p><strong>Mobile:</strong> <?php echo $memberData[0][
            "MemMobile"
        ]; ?></p>
        <p><strong>Degree:</strong> <?php echo $memberData[0][
            "MemDegree"
        ]; ?></p>
        <p><strong>Roll No:</strong> <?php echo $memberData[0][
            "MemRollNo"
        ]; ?></p>
        <p><strong>Position:</strong> <?php echo $memberData[0][
            "MemPosition"
        ]; ?></p>
        <!-- Update Image Button & Form -->
        <div class="image-update">
          <button id="showFormBtn">Update Image</button>

          <form id="updateImageForm" style="display: none;" onsubmit="return updateImage(event);">
            <input
              type="text"
              id="newImageUrl"
              name="imageUrl"
              placeholder="/api/images/1234"
              required
            />
            <button type="submit">Submit</button>
          </form>

          <p id="update-status" style="margin-top: 10px; color: green;"></p>
        </div>

      </div>
    </div>

    <div class="info-cards">
      <div class="info-card">
        <h4>Account Information</h4>
        <p><strong>Password:</strong> <?php echo $memberData[0][
            "MemPassword"
        ]; ?></p>
        <p><strong>Access Status:</strong> <?php echo $memberData[0][
            "MemAccessGranted"
        ]
            ? "Granted"
            : "Denied"; ?></p>
      </div>
      <div class="info-card">
        <h4>Additional Details</h4>
        <p><strong>Role:</strong> <?php echo $memberData[0]["MemRole"]; ?></p>
      </div>
    </div>
  </div>
  <script>
    const showFormBtn = document.getElementById('showFormBtn');
    const form = document.getElementById('updateImageForm');
    const statusMsg = document.getElementById('update-status');

    showFormBtn.addEventListener('click', () => {
      form.style.display = form.style.display === 'none' ? 'block' : 'none';
      statusMsg.textContent = '';
    });

    async function updateImage(event) {
      event.preventDefault();

      const imageInput = document.getElementById('newImageUrl');
      const newUrl = imageInput.value.trim();
      const fullUrl = newUrl;

      try {
        const memId = "<?php echo $memberData[0]["MemId"]; ?>";

        const response = await fetch('<?php echo $url; ?>/admin/member/updateimage', {

          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({
            MemImageUrl: newUrl,
            MemId : memId
          })
        });

        if (!response.ok) {
          throw new Error("Failed to update image");
        }

        // Update profile image live on UI
        document.querySelector('.user-info img').src = fullUrl;
        statusMsg.style.color = 'green';
        statusMsg.textContent = "Profile image updated successfully!";
      } catch (err) {
        statusMsg.style.color = 'red';
        statusMsg.textContent = "Error updating image.";
      }

      return false;
    }
  </script>


</body>
</html>
