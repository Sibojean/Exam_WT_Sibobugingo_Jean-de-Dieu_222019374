 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIRTUAL OCCUPATIONAL THERAPISTS SESSIONS PLATFORM</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    /* General CSS styles */
    header {
      background-color: orange;
       ;
    }
     
    a {
      padding: 7px;
      color: white;
      background-color: blue;
      text-decoration: none;
      margin-right: 5px;
    }

    a:visited {
      color:indianred;
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

  </style>
</head>

<body style="background-color: none;">
  <header>
    <ul style="list-style-type: none; padding: 0;">
      <li style="display: inline; margin-right: 10px;">
        <ul style="list-style-type: none; padding: 0;">
          <li style="display: inline; margin-right: 100px;"><a href="./home.html">HOME</a></li>
          <li style="display: inline; margin-right: 100px;"><a href="./about.html">ABOUT</a></li>
          <li style="display: inline; margin-right: 100px;"><a href="./contact.html">CONTACT</a></li>
          <li style="display: inline; margin-right: 100px;">
        <a href="./ourservice.html">OUR SERVICE</a>
      </li>
          
            <center>
          <li class="dropdown" style="display: inline; margin-right: 50px;">
            <a href="#" style="padding: 10px; color: white; background-color: green; margin-right: -500px;"> TABLES LIST </a>
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
       <!-- LOG OUT button -->
   <!-- LOG OUT button -->
    <a class="logout" href="logout.php">LOG OUT</a>

    </ul>
  </header>

<body style="background-color: yellowgreen;">

     <h1>Therapists Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
      <label for="therapist_id">Therapist ID:</label>
      <input type="number" id="therapist_id" name="therapist_id" required><br><br>

      <label for="therapist_first_name">First Name:</label>
      <input type="text" id="therapist_first_name" name="therapist_first_name" required><br><br>

      <label for="therapist_last_name">Last Name:</label>
      <input type="text" id="therapist_last_name" name="therapist_last_name" required><br><br>

      <label for="specialization">Specialization:</label>
      <input type="text" id="specialization" name="specialization" required><br><br>

      <label for="experience_years">Experience (years):</label>
      <input type="number" id="experience_years" name="experience_years" required><br><br>

      <input type="submit" name="add" value="Insert"><br><br>

      <a href="./home.html">Go Back to Home</a>
    </form>

    <?php
    include('database_connection.php'); // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
      // Retrieve input values from POST request
      $therapist_id = $_POST['therapist_id'];
      $therapist_first_name = $_POST['therapist_first_name'];
      $therapist_last_name = $_POST['therapist_last_name'];
      $specialization = $_POST['specialization'];
      $experience_years = $_POST['experience_years'];

      // Check if therapist_id already exists
      $check_therapist_query = "SELECT * FROM therapists WHERE therapist_id = ?";
      $stmt = $connection->prepare($check_therapist_query);
      $stmt->bind_param("i", $therapist_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
        echo "<p style='color: red;'>Your therapist ID is already used. Please try again.</p>";
      } else {
        // Prepare SQL statement for insertion
        $stmt = $connection->prepare("INSERT INTO therapists (therapist_id, therapist_first_name, therapist_last_name, specialization, experience_years) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $therapist_id, $therapist_first_name, $therapist_last_name, $specialization, $experience_years); // Bind parameters

        // Execute the statement and check for success
        if ($stmt->execute()) {
          echo "<p style='color: blue;'>New record has been added successfully.</p>";
        } else {
          echo "Error inserting data: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
      }
    }
    ?>

    <section>
      <h2>Therapists Detail</h2>
      <table>
        <tr>
          <th>Therapist ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Specialization</th>
          <th>Experience (years)</th>
          <th>Delete</th>
          <th>Update</th>
        </tr>
        <?php
        // Select all therapists from the database
        $sql = "SELECT * FROM therapists";
        $result = $connection->query($sql); // Execute the query

        if ($result->num_rows > 0) {
          // Loop through the results and generate table rows
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['therapist_id']}</td>
                    <td>{$row['therapist_first_name']}</td>
                    <td>{$row['therapist_last_name']}</td>
                    <td>{$row['specialization']}</td>
                    <td>{$row['experience_years']}</td>
                    <td><a style='padding:4px' href='delete_therapist.php?therapist_id={$row['therapist_id']}'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_therapist.php?therapist_id={$row['therapist_id']}'>Update</a></td> 
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
