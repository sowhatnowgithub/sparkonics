<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Scheduler</title>
  <?php echo "<style>" . Sowhatnow\App\Views\NavBar::$STYLE . "</style>"; ?>
  <style>
  body {
    font-family: monospace;
    background-color: #282c34;
    color: skyblue;
    padding: 20px;
  }
    .content {
      padding: 40px;
      max-width: 1000px;
      margin: auto;
    }

    .button-group {
      margin-bottom: 30px;
      display: flex;
      gap: 15px;
    }

    .job-form {
      display: none;
      margin-bottom: 40px;
      border: 2px solid #003366;
      padding: 20px;
      border-radius: 8px;
      background: #fff;
    }

    .job-form label {
      display: block;
      margin: 10px 0;
    }

    input, textarea, select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
    }

    button {
      background-color: #003366;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #002244;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th, table td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }

    table th {
      background-color: #003366;
      color: white;
    }

    h1 {
      text-align: center;
      color: skyblue;
    }
  </style>
  <script>
    function showForm(formId) {
      ['addForm', 'modifyForm', 'deleteForm'].forEach(id => {
        document.getElementById(id).style.display = (id === formId + 'Form') ? 'block' : 'none';
      });
    }
  </script>
</head>
<body>

<?php echo Sowhatnow\App\Views\NavBar::$NAVBAR; ?>

<div class="content">
  <h1>Scheduler</h1>

  <div class="button-group">
    <button onclick="showForm('add')">Add Job</button>
    <button onclick="showForm('modify')">Modify Job</button>
    <button onclick="showForm('delete')">Delete Job</button>
  </div>

  <!-- Add Job Form -->
  <form id="addForm" class="job-form" method="POST" action="/admin/jobs/add">
    <h3>Add Job</h3>

    <label>Recipient Email:
      <input type="email" name="RecipientEmail" required>
    </label>

    <label>Sender Email:
      <input type="email" name="SenderEmail" required>
    </label>

    <label>Sender Email Password:
      <input type="password" name="SenderEmailPassword" required>
    </label>

    <label>Subject:
      <input type="text" name="Subject" required>
    </label>

    <label>CC:
      <input type="email" name="CC">
    </label>

    <label>Body:
      <textarea name="Body" required></textarea>
    </label>

    <label>Is Event Mail:
      <select name="IsEventMail" required>
        <option value="yes">Yes</option>
        <option value="no">No</option>
      </select>
    </label>

    <label>Start Date:
      <input type="datetime-local" name="StartDate" required>
    </label>

    <label>End Date:
      <input type="datetime-local" name="EndDate" required>
    </label>

    <label>Interval Days:
      <input type="number" step="0.0001" name="IntervalDays" min="0" required placeholder="Rember whatever you will give here it will be multiplied by 84000 forseconds ">
    </label>

    <label>Next Scheduled At:
      <!-- Set hidden value for NextScheduledAt -->
      <input type="datetime-local" name="NextScheduledAt" value="" hidden>
    </label>

    <label>Max Occurrences:
      <input type="number" name="MaxOccurrences" min="1" required>
    </label>

    <label>Active:
      <select name="Active" required>
        <option value="1">Yes</option>
      </select>
    </label>

    <button type="submit">Add Job</button>
  </form>

  <!-- Modify Job Form -->
  <form id="modifyForm" class="job-form" method="POST" action="/admin/jobs/modify">
    <h3>Modify Job</h3>
    <label>Job ID (required): <input type="number" name="JobId" required></label>
    <label>Recipient Email: <input type="email" name="RecipientEmail"></label>
    <label>Sender Email: <input type="email" name="SenderEmail"></label>
    <label>Sender Email Password: <input type="password" name="SenderEmailPassword"></label>
    <label>Subject: <input type="text" name="Subject"></label>
    <label>CC: <input type="email" name="CC"></label>
    <label>Body: <textarea name="Body"></textarea></label>
    <label>Is Event Mail:
      <select name="IsEventMail">
        <option value="">--</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
      </select>
    </label>
    <label>Start Date: <input type="datetime-local" name="StartDate"></label>
    <label>End Date: <input type="datetime-local" name="EndDate"></label>
    <label>Interval Days: <input type="number" name="IntervalDays" min="0"></label>
    <label>Next Scheduled At: <input type="datetime-local" name="NextScheduledAt" hidden></label>
    <label>Max Occurrences: <input type="number" step="0.0001" name="MaxOccurrences" min="0"></label>

    <label>Active:
      <select name="Active" required>
        <option value="1">Yes</option>
      </select>
    </label>
    <button type="submit">Modify Job</button>
  </form>

  <!-- Delete Job Form -->
  <form id="deleteForm" class="job-form" method="POST" action="/admin/jobs/delete">
    <h3>Delete Job</h3>
    <label>Job ID (required): <input type="number" name="JobId" required></label>
    <button type="submit">Delete Job</button>
  </form>

  <h3>Scheduled Jobs</h3>
  <table id="jobsTable" style="width:100%; border-collapse: collapse;">
    <thead>
      <tr>
        <th>JobId</th>
        <th>RecipientEmail</th>
        <th>Subject</th>
        <th>NextScheduledAt</th>
      </tr>
    </thead>
    <tbody>
      <?php if (is_array($data) && count($data) > 0): ?>
        <?php foreach ($data as $job): ?>
          <?php
          if (!is_array($job)) {
              $job = [];
          }

          $jobId = htmlspecialchars($job["JobId"] ?? "");
          $recipientEmail = htmlspecialchars($job["RecipientEmail"] ?? "");
          $subject = htmlspecialchars($job["Subject"] ?? "");
          $nextScheduledAt = htmlspecialchars($job["NextScheduledAt"] ?? "");
          $jobJson = htmlspecialchars(
              json_encode($job ?: new stdClass()),
              ENT_QUOTES,
          );
          ?>
          <tr class="job-row" tabindex="0" data-job='<?= $jobJson ?>' style="cursor: pointer;">
            <td><?= $jobId ?></td>
            <td><?= $recipientEmail ?></td>
            <td><?= $subject ?></td>
            <td><?= $nextScheduledAt ?></td>
          </tr>
          <tr class="job-details-row" style="display:none; background:#f9f9f9;">
            <td colspan="4" style="font-family: monospace; white-space: pre-wrap;"></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" style="text-align:center;">No jobs found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <script>
    // Show/hide forms based on button clicks
    // Already defined in <head> as showForm(formId)

    // Toggle job details on row click or keyboard interaction
    document.querySelectorAll('.job-row').forEach(row => {
      row.addEventListener('click', () => {
        const detailsRow = row.nextElementSibling;
        const detailsCell = detailsRow.querySelector('td');
        if (detailsRow.style.display === 'table-row') {
          detailsRow.style.display = 'none';
          detailsCell.textContent = '';
        } else {
          const jobData = JSON.parse(row.dataset.job);
          detailsCell.textContent = JSON.stringify(jobData, null, 2);
          detailsRow.style.display = 'table-row';
        }
      });

      row.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          row.click();
        }
      });
    });
  </script>
</div>

</body>
</html>
