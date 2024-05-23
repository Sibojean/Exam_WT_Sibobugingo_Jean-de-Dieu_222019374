 <?php
    // Connection details
    include('database_connection.php');

    // Check if activity_id is set
    if(isset($_REQUEST['activity_id'])) {
        $activity_id = $_REQUEST['activity_id'];
        
        $stmt = $connection->prepare("SELECT * FROM activities WHERE activity_id=?");
        $stmt->bind_param("i", $activity_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $activity_name = $row['activity_name'];
            $description = $row['description'];
            $duration_minutes = $row['duration_minutes'];
            $client_id = $row['client_id'];
            $session_id = $row['session_id']; // Fetch session_id from database
        } else {
            echo "Activity not found.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Activity</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update Activity form -->
        <h2><u>Update Form of Activity</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="activity_id" value="<?php echo $activity_id; ?>">
            
            <label for="activity_name">Activity Name:</label>
            <input type="text" name="activity_name" value="<?php echo $activity_name; ?>">
            <br><br>

            <label for="description">Description:</label>
            <textarea name="description"><?php echo $description; ?></textarea>
            <br><br>

            <label for="duration_minutes">Duration (minutes):</label>
            <input type="number" name="duration_minutes" value="<?php echo $duration_minutes; ?>">
            <br><br>

            <label for="client_id">Client ID:</label>
            <input type="number" name="client_id" value="<?php echo $client_id; ?>">
            <?php
                // Check if client_id exists in the client table
                $check_client_stmt = $connection->prepare("SELECT * FROM client WHERE client_id=?");
                $check_client_stmt->bind_param("i", $client_id);
                $check_client_stmt->execute();
                $check_client_result = $check_client_stmt->get_result();
                
                if($check_client_result->num_rows == 0) {
                    echo "<span style='color:red;'> Unknown client ID</span>";
                }
            ?>
            <br><br>

            <label for="session_id">Session ID:</label>
            <input type="text" name="session_id" value="<?php echo $session_id; ?>">
            <?php
                // Check if session_id exists in the session table
                $check_session_stmt = $connection->prepare("SELECT * FROM sessions WHERE session_id=?");
                $check_session_stmt->bind_param("s", $session_id);
                $check_session_stmt->execute();
                $check_session_result = $check_session_stmt->get_result();
                
                if($check_session_result->num_rows == 0) {
                    echo "<span style='color:red;'> Unknown session ID</span>";
                }
            ?>
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $activity_id = $_POST['activity_id'];
    $activity_name = $_POST['activity_name'];
    $description = $_POST['description'];
    $duration_minutes = $_POST['duration_minutes'];
    $client_id = $_POST['client_id'];
    $session_id = $_POST['session_id']; // Fetch session_id from form
    
    // Check if client_id exists in the client table
    $check_client_stmt = $connection->prepare("SELECT * FROM client WHERE client_id=?");
    $check_client_stmt->bind_param("i", $client_id);
    $check_client_stmt->execute();
    $check_client_result = $check_client_stmt->get_result();
    
    // Check if session_id exists in the session table
    $check_session_stmt = $connection->prepare("SELECT * FROM sessions WHERE session_id=?");
    $check_session_stmt->bind_param("s", $session_id);
    $check_session_stmt->execute();
    $check_session_result = $check_session_stmt->get_result();
    
    if($check_client_result->num_rows == 0 || $check_session_result->num_rows == 0) {
        echo "<p style='color:red;'>Unknown client ID or session ID</p>";
    } else {
        // Update the activity record in the database
        $stmt = $connection->prepare("UPDATE activities SET activity_name=?, description=?, duration_minutes=?, client_id=?, session_id=? WHERE activity_id=?");
        $stmt->bind_param("ssiiii", $activity_name, $description, $duration_minutes, $client_id, $session_id, $activity_id);
        $stmt->execute();
        
        // Redirect to activities.php or any other page displaying activity records
        header('Location: activities.php');
        exit(); // Ensure that no other content is sent after the header redirection
    }
}
?>
