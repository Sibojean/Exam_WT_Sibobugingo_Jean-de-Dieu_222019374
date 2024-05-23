 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIRTUAL OCCUPATIONAL THERAPISTS SESSIONS PLATFORM</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    /* General CSS styles */
    a:visited {
      color: purple;
    }

    a:link {
      color: brown;
    }

    a:hover {
      background-color: white;
    }

    a:active {
      background-color: blue;
    }

    button.btn {
      margin-left: 15px; 
      margin-top: 7px;
    }

    input.form-control {
      padding: 10px;
    }
 table {
  width: 75%;
  border-collapse: collapse;
  margin: 20px 0;
  font-size: 18px;
  text-align: left;
}
td:first-child {
      background-color: #333333;
      color: #ffffff;
    }

    th, td {
  padding: 12px 15px;
  border: 5px solid #ddd;
}

th {
  background-color: #f4f4f4;
  color: #333;
}

/* Alternating row colors */
tr:nth-child(even) {
  background-color: #f9f9f9;
}

tr:nth-child(odd) {
  background-color: #fff;
}

/* Hover effect */
tr:hover {
  background-color: #f1f1f1;
}

/* Styling for specific elements in the table */
th {
  font-weight: bold;
  text-transform: uppercase;
  background-color: #007BFF;
  color: white;
}

td {
  color: #333;
}


    section {
      padding: 20px; 
      border-bottom: 3px solid #ddd; 
    }

    footer {
      text-align: center; 
      padding: 10px; 
      background-color: darkgray; 
    }

    .logout {
      position: absolute;
      top: 20px;
      right: 20px;
      color: green;
      background-color: #cc0000;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 20px;
      transition: background-color 0.3s ease;
    }

    .logout:hover {
      background-color: #990000;
    }

    /* Error messages in red */
    .error {
      color: red;
    }
  </style>
  <!-- JavaScript function for insert confirmation -->
  <script>
    function confirmInsert() {
      return confirm("Are you sure you want to insert this record?");
    }
  </script>
</head>

<body style="background-color: lightblue;">
  <header>
    <ul style="list-style-type: none; padding: 0;">
      <li style="display: inline; margin-right: 10px;">
        <a href="./home.html">HOME</a>
      </li>
      <li style="display: inline; margin-right: 10px;">
        <a href="./about.html">ABOUT</a>
      </li>
      <li style="display: inline; margin-right: 10px;">
        <a href="./contact.html">CONTACT</a>
      </li>
      <li style="display: inline; margin-right: 80px;">
        <a href="./ourservice.html">OUR SERVICE</a>
      </li>
      <li class="dropdown" style="display: inline; margin-right: 10px;">
         <center>
          <li class="dropdown" style="display: inline; margin-right: 10px;">
        <a href="#" style="padding: 10px; color: white; background-color: blue; text-decoration: none; margin-right: 15px;">VIEW TABLES</a>
            <div class="dropdown-contents">
              <!-- Links inside the dropdown menu -->
              <a href="./therapists.php">THERAPISTS</a>
              <a href="./sessions.php">SESSION</a>
              <a href="./payments.php">PAYMENT</a>
              <a href="./files.php">FILES</a>
              <a href="./client.php"> CLIENTS</a>
              <a href="./chathistory.php">CHART HISTORY</a>
              <a href="./assessmentforms.php">ASSESSMENT</a>
              <a href="./appointments.php">APPOINTMENT</a>
              <a href="./activities.php">ACTIVITIES</a>
            </div>
          </li>
        </center>
    <!-- LOG OUT button -->
    <a class="logout" href="logout.php">LOG OUT</a>
  </header>

  <body style="background-color: yellowgreen;">

    <h1>Activities Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
      <label for="activity_id">Activity ID:</label>
      <input type="number" id="activity_id" name="activity_id" required><br><br>

      <label for="activity_name">Activity Name:</label>
      <input type="text" id="activity_name" name="activity_name" required><br><br>

      <label for="description">Description:</label>
      <input type="text" id="description" name="description" required><br><br>

      <label for="duration_minutes">Duration (minutes):</label>
      <input type="number" id="duration_minutes" name="duration_minutes" required><br><br>

      <label for="client_id">Client ID:</label>
      <input type="number" id="client_id" name="client_id" required><br><br>

      <label for="session_id">Session ID:</label>
      <input type="number" id="session_id" name="session_id" required><br><br>

      <input type="submit" name="add" value="Insert"><br><br>

      <a href="./home.html">Go Back to Home</a>
    </form>

    <?php
    include('database_connection.php'); // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
      // Retrieve input values from POST request
      $activity_id = $_POST['activity_id'];
      $activity_name = $_POST['activity_name'];
      $description = $_POST['description'];
      $duration_minutes = $_POST['duration_minutes'];
      $client_id = $_POST['client_id'];
      $session_id = $_POST['session_id'];

      // Check if activity_id already exists
      $check_activity_query = "SELECT * FROM activities WHERE activity_id = ?";
      $stmt = $connection->prepare($check_activity_query);
      $stmt->bind_param("i", $activity_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
          echo "<p class='error'>Activity ID is already used.</p>";
          exit(); // Exit if activity_id already exists
      }

      // Check if client_id exists in clients table
      $check_client_query = "SELECT * FROM client WHERE client_id = ?";
      $stmt = $connection->prepare($check_client_query);
      $stmt->bind_param("i", $client_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows == 0) {
          echo "<p class='error'>Client ID does not match!reka ububwa rero.</p>";
          exit(); // Exit if client_id does not exist in clients table
      }

      // Check if session_id exists in sessions table
      $check_session_query = "SELECT * FROM sessions WHERE session_id = ?";
      $stmt = $connection->prepare($check_session_query);
      $stmt->bind_param("i", $session_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows == 0) {
          echo "<p class='error'>Session ID does not match.</p>";
          exit(); // Exit if session_id does not exist in sessions table
      }

      // Prepare SQL statement for insertion
      $stmt = $connection->prepare("INSERT INTO activities (activity_id, activity_name, description, duration_minutes, client_id, session_id) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssii", $activity_id, $activity_name, $description, $duration_minutes, $client_id, $session_id); // Bind parameters

      // Execute the statement and check for success
      if ($stmt->execute()) {
        echo "New record has been added successfully.<br><br><a href='activities.php'>Back to Form</a>";
      } else {
        echo "Error inserting data: " . $stmt->error;
      }

      // Close the statement
      $stmt->close();
    }
    ?>

    <section>
      <h2>Activities Detail</h2>
      <table>
        <tr>
          <th>Activity ID</th>
          <th>Activity Name</th>
          <th>Description</th>
          <th>Duration (minutes)</th>
          <th>Client ID</th>
          <th>Session ID</th>
          <th>Delete</th>
          <th>Update</th>
        </tr>
        <?php
        // Select all activities from the database
        $sql = "SELECT * FROM activities";
        $result = $connection->query($sql); // Execute the query

        if ($result->num_rows > 0) {
          // Loop through the results and generate table rows
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['activity_id']}</td>
                    <td>{$row['activity_name']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['duration_minutes']}</td>
                    <td>{$row['client_id']}</td>
                    <td>{$row['session_id']}</td>
                    <td><a style='padding:4px' href='delete_activity.php?activity_id={$row['activity_id']}'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_activity.php?activity_id={$row['activity_id']}'>Update</a></td> 
                  </tr>";
          }
        } else {
          // If no data is found, display a message in the table
          echo "<tr><td colspan='8'>No data found</td></tr>";
        }
        ?>
      </table>
    </section>

    <footer>
      <h2>UR CBE BIT &copy; 2024 &reg; Designed by: @Jean Sibo</h2>
    </footer>

  </body>
</html>
