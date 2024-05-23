<?php
// Start session
session_start();

// Connection details
include 'database_connection.php'; // Include the file with database connection details
$error = ""; // Initialize error variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    // Sanitize user input
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Prepare and execute SQL statement to prevent SQL injection
    $sql = "SELECT id, username, password FROM user WHERE username=?";
    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];
            // Verify the hashed password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $row['id']; // Set session user_id
                header("Location: home.html"); // Redirect to home page after successful login
                exit();
            } else {
                $error = "Invalid username or password"; // Set error message if password is incorrect
            }
        } else {
            $error = "User not found"; // Set error message if user does not exist
        }
    } else {
        // Error handling for prepared statement failure
        $error = "Database error: " . $connection->error;
    }

    // Close statement
    $stmt->close();
} else {
    // Handling case when form is not submitted
    $error = "Please fill out the login form";
}

// Close connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>
<center>
<body bgcolor="orange">
    <h2>User Login Form</h2>
    <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </center>
    </form>

    <script>
        // JavaScript confirmation prompt before submitting the form
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            var confirmLogin = confirm("Do you want to login?");
            if (!confirmLogin) {
                event.preventDefault(); // Prevent form submission if user cancels
            }
        });
    </script>
    <body style="background-image: url('./image/downloa.jpeg');"> <!-- Corrected placement of body tag -->
    <p><?php echo $error; ?></p>

</body>
</html>
