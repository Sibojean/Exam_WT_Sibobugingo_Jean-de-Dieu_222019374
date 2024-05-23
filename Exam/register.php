<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
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
      width: 75%; /* Set table to full width */
      border-collapse: collapse; /* Merge borders */
    }

    /* Special Styling for First Column */
    td:first-child {
      background-color: #333333;
      color: #ffffff;
    }

    /* Table Cells */
    td {
      padding: 8px;
      border-bottom: 1px solid #dddddd;
    }

    /* Hover Effect */
    tr:hover {
      background-color: #e9e9e9;
    }

    th, td {
      border: 2px solid black; /* Table borders */
      padding: 10px; /* Padding for readability */
      text-align: left;
    }

    th {
      background-color: orange; /* Header row color */
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
    /* Positioning for log out button */
    .logout-btn {
      position: absolute;
      top: 10px;
      right: 10px;
    }
  </style> 
    <script>
        function validateForm() {
            // Validate email format
            var email = document.getElementById("email").value;
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            // Validate password length
            var password = document.getElementById("password").value;
            if (password.length < 8) {
                alert("Password must be at least 8 characters long contain symbols and numbers.");
                return false;
            }

            // Ask for confirmation before submitting the form
            var confirmation = confirm("Are you sure you want to submit?");
            if (confirmation) {
                return true; // User confirmed, proceed with form submission
            } else {
                return false; // User canceled, do not submit the form
            }
        }
    </script>
</head>
<body>
    <h2>Registration Form</h2>
    <?php
    // Connection details
    include 'database_connection.php';

    // Start output buffering
    ob_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieving form data and sanitizing inputs
        $fname = mysqli_real_escape_string($connection, $_POST['fname']);
        $lname = mysqli_real_escape_string($connection, $_POST['lname']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // Check if the username or email already exists
        $sql_check = "SELECT * FROM user WHERE email='$email' OR username='$username'";
        $result_check = $connection->query($sql_check);

        if ($result_check->num_rows > 0) {
            // Username or email already exists, display an error message
            echo "Username or email already exists. Please choose another one.";
        } else {
            // Proceed with inserting the data into the database
            $sql = "INSERT INTO user (firstname, lastname, email, username, password) 
                    VALUES ('$fname','$lname','$email', '$username', '$password')";

            if ($connection->query($sql) === TRUE) {
                // Redirect to login page after successful registration
                header("Location:login.php");
                exit();
            } else {
                // Display error message if insertion fails
                echo "Error: " . $sql . "<br>" . $connection->error;
            }
        }
    }

    // Close the database connection
    $connection->close();

    // Flush output buffer and turn off output buffering
    ob_end_flush();
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required><br><br>

        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
