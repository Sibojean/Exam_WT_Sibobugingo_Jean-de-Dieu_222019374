 <?php
// Connection details
$host = "localhost";
$user = "sibojean"; 
$pass = "222019374"; 
$database = "virtual _occupational_therapy_sessions_platform";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if client_id is set
if (isset($_REQUEST['client_id'])) {
    $client_id = $_REQUEST['client_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM client WHERE client_id = ?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = htmlspecialchars($row['name'], ENT_QUOTES);
        $email = htmlspecialchars($row['email'], ENT_QUOTES);
        $phone_number = htmlspecialchars($row['phone_number'], ENT_QUOTES);
        $address = htmlspecialchars($row['address'], ENT_QUOTES);
    } else {
        echo "Page not found.";
        exit();
    }

    // Close statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Client</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update client form -->
        <h2><u>Update Client Form</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="client_id" value="<?php echo isset($client_id) ? $client_id : ''; ?>">
            
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" required>
            <br><br>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
            <br><br>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" value="<?php echo isset($phone_number) ? $phone_number : ''; ?>" required>
            <br><br>

            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo isset($address) ? $address : ''; ?>" required>
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
// Handle form submission
if (isset($_POST['up'])) {
    // Retrieve updated values from the form
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
    $phone_number = htmlspecialchars($_POST['phone_number'], ENT_QUOTES);
    $address = htmlspecialchars($_POST['address'], ENT_QUOTES);
    $client_id = htmlspecialchars($_POST['client_id'], ENT_QUOTES); // Retrieve client_id from the form

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE client SET name = ?, email = ?, phone_number = ?, address = ? WHERE client_id = ?");
    $stmt->bind_param("ssssi", $name, $email, $phone_number, $address, $client_id);

    if ($stmt->execute()) {
        // Redirect to client.php on successful update
        header('Location: client.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        // Handle error (e.g., display an error message)
        echo "Failed to update. Please try again.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$connection->close();
?>
