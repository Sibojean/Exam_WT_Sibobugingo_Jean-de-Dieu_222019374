 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIRTUAL OCCUPATIONAL THERAPISTS SESSIONS PLATFORM</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
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
  </style>
    }

  </style>
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
        <ul style="list-style-type: none; padding: 0;">
          <li style="display: inline; margin-right: 8px;"><a href="./home.html">HOME</a></li>
          <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a></li>
          <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a></li>
          <li style="display: inline; margin-right: 80px;">
        <a href="./ourservice.html">OUR SERVICE</a>
      </li>
          <center>
          <li class="dropdown" style="display: inline; margin-right: 10px;">
            <a href="#" style="padding: 10px; color: white; background-color: greenyellow; text-decoration: none; margin-right: 15px;"> TABLES </a>
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
    <!-- LOG OUT button -->
    <a class="logout" href="logout.php">LOG OUT</a>
        </ul>
      </li>
    </ul>
  </header>

  <body style="background-color: yellowgreen;">

    <h1>Sessions Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
      <label for="session_id">Session ID:</label>
      <input type="number" id="session_id" name="session_id" required><br><br>

      <label for="start_time">Start Time:</label>
      <input type="datetime-local" id="start_time" name="start_time" required><br><br>

      <label for="end_time">End Time:</label>
      <input type="datetime-local" id="end_time" name="end_time" required><br><br>

      <label for="location">Location:</label>
      <input type="text" id="location" name="location" required><br><br>

      <label for="client_id">Client ID:</label>
      <input type="number" id="client_id" name="client_id" required><br><br>

      <input type="submit" name="add" value="Insert"><br><br>

      <a href="./home.html">Go Back to Home</a> <!-- Corrected the path to start with "./" -->
    </form>

    <?php
    include('database_connection.php'); // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
      // Retrieve input values from POST request
      $session_id = $_POST['session_id'];
      $start_time = $_POST['start_time'];
      $end_time = $_POST['end_time'];
      $location = $_POST['location'];
      $client_id = $_POST['client_id'];

      // Check if session_id already exists
      $check_session_query = "SELECT * FROM sessions WHERE session_id = ?";
      $stmt = $connection->prepare($check_session_query);
      $stmt->bind_param("i", $session_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
        echo "<section style='color: red; font-size: 24px;'>Your session ID is already used!</section>";
        exit(); // Exit if session_id already exists
      }

      // Check if client_id exists in clients table
      $check_client_query = "SELECT * FROM client WHERE client_id = ?";
      $stmt = $connection->prepare($check_client_query);
      $stmt->bind_param("i", $client_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows == 0) {
        echo "<section style='color: red; font-size: 24px;'>Client ID does not match.</section>";
        exit(); // Exit if client_id does not exist in clients table
      }

      // Prepare SQL statement for insertion
      $stmt = $connection->prepare("INSERT INTO sessions (session_id, start_time, end_time, location, client_id) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("issii", $session_id, $start_time, $end_time, $location, $client_id); // Bind parameters

      // Execute the statement and check for success
      if ($stmt->execute()) {
        echo "<section style='color: blue; font-size: 36px;'>New record has been inserted well!</section>";
      } else {
        echo "Error inserting data: " . $stmt->error;
      }

      // Close the statement
      $stmt->close();
    }
    ?>

    <section>
      <h2>Sessions Detail</h2>
      <table>
        <tr>
          <th>Session ID</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Location</th>
          <th>Client ID</th>
          <th>Delete</th>
          <th>Update</th>
        </tr>
        <?php
        // Select all sessions from the database
        $sql = "SELECT * FROM sessions";
        $result = $connection->query($sql); // Execute the query

        if ($result->num_rows > 0) {
          // Loop through the results and generate table rows
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['session_id']}</td>
              <td>{$row['start_time']}</td>
              <td>{$row['end_time']}</td>
              <td>{$row['location']}</td>
              <td>{$row['client_id']}</td>
              <td><a style='padding:4px' href='delete_session.php?session_id={$row['session_id']}'>Delete</a></td> 
              <td><a style='padding:4px' href='update_session.php?session_id={$row['session_id']}'>Update</a></td> 
            </tr>";
          }
        } else {
          // If no data is found, display a message in the table
          echo "<tr><td colspan='7'>No data found</td></tr>";
        }
        ?>
      </table>
    </section>

    <footer>
      <h2>UR CBE BIT &copy; 2024 &reg; Designed by: @Jean  Sibo</h2> <!-- Corrected "Designer" to "Designed" -->
    </footer>

  </body>
</html>
