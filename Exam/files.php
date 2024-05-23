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
      border-bottom: 3px solid #ddd; 
    }

    footer {
      text-align: center; 
      padding: 10px; 
      background-color: darkgray; 
    }

    /* Error message */
    .error {
      color: red;
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
    
    <ul style="list-style-type: none; padding: 0;">
      <li style="display: inline; margin-right: 10px;">
        <ul style="list-style-type: none; padding: 0;">
          <li style="display: inline; margin-right: 8px;"><a href="./home.html">HOME</a></li>
          <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a></li>
           <li style="display: inline; margin-right: 80px;">
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
    </ul>
  </header>

    <h1>Files Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
      <label for="file_id">File ID:</label>
      <input type="number" id="file_id" name="file_id" required><br><br>

      <label for="file_name">File Name:</label>
      <input type="text" id="file_name" name="file_name" required><br><br>

      <label for="file_type">File Type:</label>
      <input type="text" id="file_type" name="file_type" required><br><br>

      <label for="file_size">File Size:</label>
      <input type="number" id="file_size" name="file_size" required><br><br>

      <label for="upload_date">Uploaded Date:</label>
      <input type="date" id="upload_date" name="upload_date" required><br><br>

      <label for="client_id">Client ID:</label>
      <input type="number" id="client_id" name="client_id" required><br><br>

      <label for="session_id">Session ID:</label>
      <input type="number" id="session_id" name="session_id" required><br><br>

      <input type="submit" name="add" value="Insert"><br><br>

      <a href="./home.html">Go Back to Home</a>
    </form>

    <!-- PHP code for form submission -->
    <?php
    include('database_connection.php'); // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Retrieve input values from POST request
        $file_id = $_POST['file_id'];
        $file_name = $_POST['file_name'];
        $file_type = $_POST['file_type'];
        $file_size = $_POST['file_size'];
        $upload_date = $_POST['upload_date'];
        $client_id = $_POST['client_id'];
        $session_id = $_POST['session_id'];


             // Check if file_id already exists
      $check_file_query = "SELECT * FROM files WHERE file_id = ?";
      $stmt = $connection->prepare($check_file_query);
      $stmt->bind_param("i", $file_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
          echo "file ID is already used.";
          exit(); // Exit if file_id already exists
      }


             // Check if session_id already exists
      $check_session_query = "SELECT * FROM sessions WHERE session_id = ?";
      $stmt = $connection->prepare($check_session_query);
      $stmt->bind_param("i", $session_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
          echo "Session ID is already used.";
          exit(); // Exit if session_id already exists
      }

      // Check if client_id exists in clients table
      $check_client_query = "SELECT * FROM client WHERE client_id = ?";
      $stmt = $connection->prepare($check_client_query);
      $stmt->bind_param("i", $client_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows == 0) {
          echo "Client ID does not match.";
          exit(); // Exit if client_id does not exist in clients table
      }



        // Prepare SQL statement for insertion
        $stmt = $connection->prepare("INSERT INTO files (file_id, file_name, file_type, file_size, upload_date, client_id, session_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issisii", $file_id, $file_name, $file_type, $file_size, $upload_date, $client_id, $session_id); // Bind parameters

        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br><a href='files.php'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
    ?>

    <!-- Section for displaying files details -->
    <section>
      <h2>Files Detail</h2>
      <table>
        <tr>
          <th>File ID</th>
          <th>File Name</th>
          <th>File Type</th>
          <th>File Size</th>
          <th>Uploaded Date</th>
          <th>Client ID</th>
          <th>Session ID</th>
          <th>Delete</th>
          <th>Update</th>
        </tr>
        <?php
        // Select all files from the database
        $sql = "SELECT * FROM files";
        $result = $connection->query($sql); // Execute the query

        if ($result->num_rows > 0) {
            // Loop through the results and generate table rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                  <td>{$row['file_id']}</td>
                  <td>{$row['file_name']}</td>
                  <td>{$row['file_type']}</td>
                  <td>{$row['file_size']}</td>
                  <td>{$row['upload_date']}</td>
                  <td>{$row['client_id']}</td>
                  <td>{$row['session_id']}</td>
                  <td><a style='padding:4px' href='delete_file.php?file_id={$row['file_id']}'>Delete</a></td> 
                  <td><a style='padding:4px' href='update_file.php?file_id={$row['file_id']}'>Update</a></td> 
                </tr>";
            }
        } else {
            // If no data is found, display a message in the table
            echo "<tr><td colspan='9'>No data found</td></tr>";
        }
        ?>
      </table>
    </section>

    <!-- Footer section -->
    <footer>
      <h2>UR CBE BIT &copy; 2024 &reg; Designed by: @Jean  Sibo</h2>
    </footer>

  </body>
</html>
