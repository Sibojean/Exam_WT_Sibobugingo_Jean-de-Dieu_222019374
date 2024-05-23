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

    footer {
      text-align: center; 
      padding: 10px; 
      background-color: darkgray; 
    }

    /* Error message */
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
        <ul style="list-style-type: none; padding: 0;">
          <li style="display: inline; margin-right: 8px;"><a href="./home.html">HOME</a></li>
          <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a></li>
          <li style="display: inline; margin-right: 80px;">
        <a href="./contact.html">CONTACT</a>
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
             
          </li>
        </ul>
      </li>
    </ul>
  </header>
  <!-- LOG OUT button -->
    <a class="logout" href="logout.php">LOG OUT</a>

  <body style="background-color: yellowgreen;">

    <h1>Clients Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
      <label for="client_id">Client ID:</label>
      <input type="number" id="client_id" name="client_id" required><br><br>

      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required><br><br>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required><br><br>

      <label for="phone_number">Phone Number:</label>
      <input type="text" id="phone_number" name="phone_number" required><br><br>

      <label for="address">Address:</label>
      <input type="text" id="address" name="address" required><br><br>

      <input type="submit" name="add" value="Insert"><br><br>

      <a href="./home.html">Go Back to Home</a>
    </form>

    <?php
    include('database_connection.php'); // Include the database connection

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
      // Retrieve input values from POST request
      $client_id = $_POST['client_id'];
      $name = $_POST['name'];
      $email = $_POST['email'];
      $phone_number = $_POST['phone_number'];
      $address = $_POST['address'];

      // Check if client_id already exists
      $check_client_query = "SELECT * FROM client WHERE client_id = ?";
      $stmt = $connection->prepare($check_client_query);
      $stmt->bind_param("i", $client_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows > 0) {
        echo "<p class='error'>Your ID is already used. Please enter your correct ID!</p>";
      } else {
        // Prepare SQL statement for insertion
        $stmt = $connection->prepare("INSERT INTO client (client_id, name, email, phone_number, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $client_id, $name, $email, $phone_number, $address); // Bind parameters

        // Execute the statement and check for success
        if ($stmt->execute()) {
          echo "New record has been added successfully.<br><br><a href='client.php'>Back to Form</a>";
        } else {
          echo "Error inserting data: " . $stmt->error;
        }
      }

      // Close the statement
      $stmt->close();
    }
    ?>

    <section>
      <h2>Clients Detail</h2>
      <table>
        <tr>
          <th>Client ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Address</th>
          <th>Delete</th>
          <th>Update</th>
        </tr>
        <?php
        // Select all clients from the database
        $sql = "SELECT * FROM client";
        $result = $connection->query($sql); // Execute the query

        if ($result->num_rows > 0) {
          // Loop through the results and generate table rows
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['client_id']}</td>
              <td>{$row['name']}</td>
              <td>{$row['email']}</td>
              <td>{$row['phone_number']}</td>
              <td>{$row['address']}</td>
              <td><a style='padding:4px' href='delete_client.php?client_id={$row['client_id']}'>Delete</a></td> 
              <td><a style='padding:4px' href='update_client.php?client_id={$row['client_id']}'>Update</a></td> 
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
