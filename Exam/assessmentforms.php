   <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIRTUAL OCCUPATIONAL THERAPISTS SESSIONS PLATFORM</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    /* General CSS styles */
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


/* General CSS styles */
    /* Your existing CSS styles here */
    
    /* Big blue message */
    .success {
      font-size: 24px;
      color: blue;
    }

    /* Red message */
    .error {
      color: red;
    section {
      padding: 20px;
      border-bottom: 3px solid #ddd;
    }

    footer {
      text-align: center;
      padding: 10px;
      background-color: darkgray;
    }

    /* Dropdown styles */
    .dropdown-contents {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }

    .dropdown-contents a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown:hover .dropdown-contents {
      display: block;
    }
     

    /* Different colors for Tables and Settings dropdown */
    .dropdown.tables .dropdown-contents {
      background-color: #66ccff; /* Light Blue */
    }

    .dropdown.settings .dropdown-contents {
      background-color: #ff6666; /* Light Red */
    }
  </style>
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
          <li class="dropdown tables" style="display: inline; margin-right: 10px;">
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
               
            </div>
          </li>
        </ul>
      </li>
    </ul>
     <!-- LOG OUT button -->
    <a class="logout" href="logout.php">LOG OUT</a>
  </header>

<body style="background-color: yellowgreen;">

    <h1>Assessment Forms Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
        <label for="form_id">Form ID:</label>
        <input type="number" id="form_id" name="form_id" required><br><br>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required><br><br>

        <label for="created_date">Created Date:</label>
        <input type="date" id="created_date" name="created_date" required><br><br>

        <label for="client_id">Client ID:</label>
        <input type="number" id="client_id" name="client_id" required><br><br>

        <label for="session_id">Session ID:</label>
        <input type="number" id="session_id" name="session_id" required><br><br>

        <input type="submit" name="add" value="Insert"><br><br>

        <a href="./home.html">Go Back to Home</a> <!-- Corrected the path to start with "./" -->
    </form>

    <?php
    include('database_connection.php'); // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
        // Retrieve input values from POST request
        $form_id = $_POST['form_id'];
        $description = $_POST['description'];
        $created_date = $_POST['created_date'];
        $client_id = $_POST['client_id'];
        $session_id = $_POST['session_id'];

        // Check if form_id already exists
        $check_form_query = "SELECT * FROM assessmentforms WHERE form_id = ?";
        $stmt = $connection->prepare($check_form_query);
        $stmt->bind_param("i", $form_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<p class='error'>Form ID is already used.</p>";
            exit(); // Exit if form_id already exists
        }

        // Check if client_id exists in clients table
        $check_client_query = "SELECT * FROM client WHERE client_id = ?";
        $stmt = $connection->prepare($check_client_query);
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            echo "<p class='error'>Client ID does not match.</p>";
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
        $stmt = $connection->prepare("INSERT INTO assessmentforms (form_id, description, created_date, client_id, session_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issii", $form_id, $description, $created_date, $client_id, $session_id); // Bind parameters

        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo "New record has been added successfully.<br><br><a href='assessmentforms.php'>Back to Form</a>";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
    ?>

    <section>
        <h2>Assessment Forms Detail</h2>
        <table>
            <tr>
                <th>Form ID</th>
                <th>Description</th>
                <th>Created Date</th>
                <th>Client ID</th>
                <th>Session ID</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>
            <?php
            // Select all assessment forms from the database
            $sql = "SELECT * FROM assessmentforms";
            $result = $connection->query($sql); // Execute the query

            if ($result->num_rows > 0) {
                // Loop through the results and generate table rows
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['form_id']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['created_date']}</td>
                            <td>{$row['client_id']}</td>
                            <td>{$row['session_id']}</td>
                            <td><a style='padding:4px' href='delete_assessmentform.php?form_id={$row['form_id']}'>Delete</a></td> 
                            <td><a style='padding:4px' href='update_assessmentform.php?form_id={$row['form_id']}'>Update</a></td> 
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
