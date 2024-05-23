  <?php
// Connection details
$host = "localhost";
$user = "sibojean"; 
$pass = "222019374"; 
$database = "virtual _occupational_therapy_sessions_platform"; // Removed spaces from the database name

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if file_id is set
if (isset($_REQUEST['file_id'])) {
    $file_id = $_REQUEST['file_id'];

    // Use prepared statement
    $stmt = $connection->prepare("SELECT * FROM files WHERE file_id = ?");
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_name = htmlspecialchars($row['file_name'], ENT_QUOTES);
        $file_type = htmlspecialchars($row['file_type'], ENT_QUOTES);
        $upload_date = htmlspecialchars($row['upload_date'], ENT_QUOTES);
        $client_id = htmlspecialchars($row['client_id'], ENT_QUOTES);
        $session_id = htmlspecialchars($row['session_id'], ENT_QUOTES);
    } else {
        echo "Page not found.";
        exit();
    }

    // Close statement
    $stmt->close();
}

// Check if client_id exists in clients table
function isValidClient($client_id, $connection) {
    $stmt = $connection->prepare("SELECT * FROM client  WHERE client_id = ?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Check if session_id exists in sessions table
function isValidSession($session_id, $connection) {
    $stmt = $connection->prepare("SELECT * FROM sessions WHERE session_id = ?");
    $stmt->bind_param("i", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update File</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update file form -->
        <h2><u>Update File Form</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="file_id" value="<?php echo isset($file_id) ? $file_id : ''; ?>">
            
            <label for="file_name">File Name:</label>
            <input type="text" name="file_name" value="<?php echo isset($file_name) ? $file_name : ''; ?>" required>
            <br><br>

            <label for="file_type">File Type:</label>
            <input type="text" name="file_type" value="<?php echo isset($file_type) ? $file_type : ''; ?>" required>
            <br><br>

            <label for="upload_date">Upload Date:</label>
            <input type="datetime-local" name="upload_date" value="<?php echo isset($upload_date) ? $upload_date : ''; ?>" required>
            <br><br>

            <label for="client_id">Client ID:</label>
            <input type="text" name="client_id" value="<?php echo isset($client_id) ? $client_id : ''; ?>" required>
            <br><br>

            <label for="session_id">Session ID:</label>
            <input type="text" name="session_id" value="<?php echo isset($session_id) ? $session_id : ''; ?>" required>
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
    $file_name = htmlspecialchars($_POST['file_name'], ENT_QUOTES);
    $file_type = htmlspecialchars($_POST['file_type'], ENT_QUOTES);
    $upload_date = htmlspecialchars($_POST['upload_date'], ENT_QUOTES);
    $client_id = htmlspecialchars($_POST['client_id'], ENT_QUOTES);
    $session_id = htmlspecialchars($_POST['session_id'], ENT_QUOTES);
    $file_id = htmlspecialchars($_POST['file_id'], ENT_QUOTES); // Retrieve file_id from the form

    // Validate client_id and session_id
    if (!isValidClient($client_id, $connection) || !isValidSession($session_id, $connection)) {
        echo "Invalid client ID or session ID!";
        exit();
    }

    // Use prepared statement for update
    $stmt = $connection->prepare("UPDATE files SET file_name = ?, file_type = ?, upload_date = ?, client_id = ?, session_id = ? WHERE file_id = ?");
    $stmt->bind_param("ssssii", $file_name, $file_type, $upload_date, $client_id, $session_id, $file_id);

    if ($stmt->execute()) {
        // Redirect to files.php on successful update
        header('Location: files.php');
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
