<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"> <!-- Proper character encoding -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsive design -->
  <title>VIRTUAL OCCUPATIONAL THERAPISTS SESSIONS PLATFORM</title>
  <link rel="stylesheet" type="text/css" href="style.css"> <!-- External CSS -->
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

    }

    section {
      padding: 20px; 
      border-bottom: 3px solid #ddd; /* Bottom border for section */
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
      padding: 15px;
      background-color: green;
      position: fixed;
      bottom: -5px;
      width: 100%;
    }
    /* Positioning for log out button */
    .logout-btn {
      position: absolute;
      top: 10px;
      right: 10px;
    }
  </style> 
</head>
<body style="background-color: lightblue;"> <!-- Corrected placement of body tag -->
  <header>
    <ul style="list-style-type: none; padding: 0;"> <!-- No list-style -->
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
    <a class="logout" href="logout.php">LOG OUT</a>
        </div>
      </li>
    </ul>
  </header>

  <body style="background-color: yellowgreen;">

    <h1>Payment Form</h1>
    <form method="post" onsubmit="return confirmInsert();">
      <label for="payment_id">Payment ID:</label>
      <input type="number" id="payment_id" name="payment_id" required><br><br>

      <label for="client_id">Client ID:</label>
      <input type="number" id="client_id" name="client_id" required><br><br>

      <label for="amount">Amount:</label>
      <input type="number" id="amount" name="amount" required><br><br>

      <label for="payment_date">Payment Date:</label>
      <input type="date" id="payment_date" name="payment_date" required><br><br>

      <input type="submit" name="add" value="Insert"><br><br>

      <a href="./home.html">Go Back to Home</a> <!-- Corrected the path to start with "./" -->
    </form>

      <?php
include('database_connection.php'); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Retrieve input values from POST request
    $payment_id = $_POST['payment_id'];
    $client_id = $_POST['client_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];

    // Check if payment_id already exists
    $check_payment_query = "SELECT * FROM payments WHERE payment_id = ?";
    $stmt = $connection->prepare($check_payment_query);
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<section><p style='color:red;'>Payment ID is already used.</p>";
        exit(); // Exit if payment_id already exists
    }

    // Check if client_id exists in clients table
    $check_client_query = "SELECT * FROM client WHERE client_id = ?";
    $stmt = $connection->prepare($check_client_query);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        echo "<section><p style='color:red;'>Client ID does not match.</p>";
        exit(); // Exit if client_id does not exist in clients table
    }

    // Prepare SQL statement for insertion
    $stmt = $connection->prepare("INSERT INTO payments (payment_id, client_id, amount, payment_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $payment_id, $client_id, $amount, $payment_date); // Bind parameters

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<section><p style='color:green;'>New record has been added successfully.</p></section>";
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>



    <section>
      <h2>Payment Detail</h2>
      <table>
        <tr>
          <th>Payment ID</th>
          <th>Client ID</th>
          <th>Amount</th>
          <th>Payment Date</th>
          <th>Delete</th>
          <th>Update</th>
        </tr>
        <?php
        // Select all payments from the database
        $sql = "SELECT * FROM payments";
        $result = $connection->query($sql); // Execute the query

        if ($result->num_rows > 0) {
          // Loop through the results and generate table rows
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>{$row['payment_id']}</td>
            <td>{$row['client_id']}</td>
            <td>{$row['amount']}</td>
            <td>{$row['payment_date']}</td>
            <td><a style='padding:4px' href='delete_payment.php?payment_id={$row['payment_id']}'>Delete</a></td> 
            <td><a style='padding:4px' href='update_payment.php?payment_id={$row['payment_id']}'>Update</a></td> 
            </tr>";
          }
        } else {
          // If no data is found, display a message in the table
          echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        ?>
      </table>
    </section>

    <footer>
      <h2>UR CBE BIT &copy; 2024 &reg; Designed by: @Jean  Sibo</h2> <!-- Corrected "Designer" to "Designed" -->
    </footer>

  </body>
</html>
