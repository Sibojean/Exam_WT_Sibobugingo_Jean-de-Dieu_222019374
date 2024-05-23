<?php
    // Connection details
    include('database_connection.php');

    // Check if appointment_id is set
    if(isset($_REQUEST['appointment_id'])) {
        $appointment_id = $_REQUEST['appointment_id'];
        
        $stmt = $connection->prepare("SELECT * FROM appointments WHERE appointment_id=?");
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $client_id = $row['client_id'];
            $appointment_date = $row['appointment_date'];
            $appointment_time = $row['appointment_time'];
            $appointment_duration_minutes = $row['appointment_duration_minutes'];
            $appointment_location = $row['appointment_location'];
            $appointment_purpose = $row['appointment_purpose'];
        } else {
            echo "Appointment not found.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Appointment</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update Appointment Form -->
        <h2><u>Update Appointment</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
            
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

            <label for="appointment_date">Appointment Date:</label>
            <input type="date" name="appointment_date" value="<?php echo $appointment_date; ?>">
            <br><br>

            <label for="appointment_time">Appointment Time:</label>
            <input type="time" name="appointment_time" value="<?php echo $appointment_time; ?>">
            <br><br>

            <label for="appointment_duration_minutes">Duration (minutes):</label>
            <input type="number" name="appointment_duration_minutes" value="<?php echo $appointment_duration_minutes; ?>">
            <br><br>

            <label for="appointment_location">Location:</label>
            <input type="text" name="appointment_location" value="<?php echo $appointment_location; ?>">
            <br><br>

            <label for="appointment_purpose">Purpose:</label>
            <input type="text" name="appointment_purpose" value="<?php echo $appointment_purpose; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $appointment_id = $_POST['appointment_id'];
    $client_id = $_POST['client_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $appointment_duration_minutes = $_POST['appointment_duration_minutes'];
    $appointment_location = $_POST['appointment_location'];
    $appointment_purpose = $_POST['appointment_purpose'];
    
    // Check if client_id exists in the client table
    $check_client_stmt = $connection->prepare("SELECT * FROM client WHERE client_id=?");
    $check_client_stmt->bind_param("i", $client_id);
    $check_client_stmt->execute();
    $check_client_result = $check_client_stmt->get_result();
    
    if($check_client_result->num_rows == 0) {
        echo "<p style='color:red;'>Unknown client ID</p>";
    } else {
        // Update the appointment record in the database
        $stmt = $connection->prepare("UPDATE appointments SET client_id=?, appointment_date=?, appointment_time=?, appointment_duration_minutes=?, appointment_location=?, appointment_purpose=? WHERE appointment_id=?");
        $stmt->bind_param("isssiis", $client_id, $appointment_date, $appointment_time, $appointment_duration_minutes, $appointment_location, $appointment_purpose, $appointment_id);
        $stmt->execute();
        
        // Redirect to appointments.php or any other page displaying appointments records
        header('Location: appointments.php');
        exit(); // Ensure that no other content is sent after the header redirection
    }
}
?>
