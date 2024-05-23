 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIRTUAL OCCUPATIONAL THERAPISTS SESSIONS PLATFORM</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    /* CSS styles for consistent styling */
    a:link {
      color: #0066cc;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    a {
      padding: 7px;
      color: white;
      background-color: turquoise;
      text-decoration: none;
      margin-right: 5px;
    }

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
      background-color: red;
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
      border-bottom: 3px solid #ddd; /* Bottom border for section */
    }

    footer {
      text-align: center; 
      padding: 10px; 
      background-color: darkgray; /* Footer background color */
    }

    /* Error message style */
    .error {
      color: red;
    }

    /* Success message style */
    .success {
      color: blue;
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
  <!-- JavaScript function for insert confirmation -->
  <script>
    function confirmInsert() {
      return confirm("Are you sure you want to insert this record?");
    }

  </script>
</head>

<body style="background-color: lightblue;">
  <header>
    <ul style="list-style-type: none; padding: 0;"> <!-- No list-style -->
      <li style="display: inline; margin-right: 8px;"><a href="./home.html">HOME</a></li>
      <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a></li>
      <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a></li>
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
    <!-- LOG OUT button -->
    <a class="logout" href="logout.php">LOG OUT</a>
    </ul>
  </header>

  <h1>Chart History Form</h1>
  <form method="post" onsubmit="return confirmInsert();">
    <label for="message_id">Message ID:</label>
    <input type="number" id="message_id" name="message_id" required><br><br>

    <label for="sender_id">Sender ID:</label>
    <input type="number" id="sender_id" name="sender_id" required><br><br>

    <label for="receiver_id">Receiver ID:</label>
    <input type="number" id="receiver_id" name="receiver_id" required><br><br>

    <label for="message">Message:</label>
    <input type="text" id="message" name="message" required><br><br>

    <label for="timestamp">Timestamp:</label>
    <input type="datetime-local" id="timestamp" name="timestamp" required><br><br>

    <input type="submit" name="add" value="Insert"><br><br>

    <a href="./home.html">Go Back to Home</a>
  </form>

   <?php
include('database_connection.php'); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Retrieve input values from POST request
    $message_id = $_POST['message_id'];
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];
    $timestamp = $_POST['timestamp'];

    // Check if message_id already exists
    $check_message_query = "SELECT * FROM chathistory WHERE message_id = ?";
    $stmt = $connection->prepare($check_message_query);
    $stmt->bind_param("i", $message_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p class='error'>Message ID is already used. Please try another ID.</p>";
        exit(); // Exit if message_id already exists
    }

    // Check if sender_id already exists
    $check_sender_query = "SELECT * FROM chathistory WHERE sender_id = ?";
    $stmt = $connection->prepare($check_sender_query);
    $stmt->bind_param("i", $sender_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p class='error'>Sender ID is already used. Please try another ID.</p>";
        exit(); // Exit if sender_id already exists
    }

    // Check if receiver_id already exists
    $check_receiver_query = "SELECT * FROM chathistory WHERE receiver_id = ?";
    $stmt = $connection->prepare($check_receiver_query);
    $stmt->bind_param("i", $receiver_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p class='error'>Receiver ID is already used. Please try another ID.</p>";
        exit(); // Exit if receiver_id already exists
    }

    // Prepare SQL statement for insertion
    $stmt = $connection->prepare("INSERT INTO chathistory (message_id, sender_id, receiver_id, message, timestamp) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiss", $message_id, $sender_id, $receiver_id, $message, $timestamp); // Bind parameters

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<p class='success'>New record has been added successfully.</p><br><br><a href='chathistory.php'>Back to Form</a>";
    } else {
        echo "<p class='error'>Error inserting data: " . $stmt->error . "</p>";
    }

    // Close the statement
    $stmt->close();
}
?>


  <section>
      <h2>Chart History Detail</h2>
      <table>
          <tr>
              <th>Message ID</th>
              <th>Sender ID</th>
              <th>Receiver ID</th>
              <th>Message</th>
              <th>Timestamp</th>
              <th>Delete</th>
              <th>Update</th>
          </tr>
          <?php
          // Select all chart history from the database
          $sql = "SELECT * FROM chathistory";
          $result = $connection->query($sql); // Execute the query

          if ($result->num_rows > 0) {
              // Loop through the results and generate table rows
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                          <td>{$row['message_id']}</td>
                          <td>{$row['sender_id']}</td>
                          <td>{$row['receiver_id']}</td>
                          <td>{$row['message']}</td>
                          <td>{$row['timestamp']}</td>
                          <td><a style='padding:4px' href='delete_chathistory.php?message_id={$row['message_id']}'>Delete</a></td> 
                          <td><a style='padding:4px' href='update_charthistory.php?message_id={$row['message_id']}'>Update</a></td> 
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
      <h2>UR CBE BIT &copy; 2024 &reg; Designed by: @Jean  Sibo</h2>
  </footer>

</body>
</html>
