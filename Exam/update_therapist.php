 <?php
include('database_connection.php');

$therapist_id = $therapist_first_name = $therapist_last_name = $specialization = $experience_years = '';
$update_status = '';

// Fetch therapist details if therapist_id is provided
if(isset($_REQUEST['therapist_id'])) {
    $therapist_id = $_REQUEST['therapist_id'];
    
    $stmt = $connection->prepare("SELECT * FROM therapists WHERE therapist_id=?");
    $stmt->bind_param("i", $therapist_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $therapist_first_name = $row['therapist_first_name'];
        $therapist_last_name = $row['therapist_last_name'];
        $specialization = $row['specialization'];
        $experience_years = $row['experience_years'];
    } else {
        echo "Therapist not found.";
    }
}

// Handle form submission
if(isset($_POST['up'])) {
    $new_therapist_id = $_POST['therapist_id'];
    $therapist_first_name = $_POST['therapist_first_name'];
    $therapist_last_name = $_POST['therapist_last_name'];
    $specialization = $_POST['specialization'];
    $experience_years = $_POST['experience_years'];
    
    // Check if the new therapist_id already exists
    $check_stmt = $connection->prepare("SELECT * FROM therapists WHERE therapist_id=?");
    $check_stmt->bind_param("i", $new_therapist_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if($check_result->num_rows > 0 && $new_therapist_id != $therapist_id) {
        $update_status = "Failed to update! Please enter a correct ID.";
    } else {
        $stmt = $connection->prepare("UPDATE therapists SET therapist_id=?, therapist_first_name=?, therapist_last_name=?, specialization=?, experience_years=? WHERE therapist_id=?");
        $stmt->bind_param("issssi", $new_therapist_id, $therapist_first_name, $therapist_last_name, $specialization, $experience_years, $therapist_id);
        $stmt->execute();
        
        header('Location: therapists.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Therapist</title>
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <h2><u>Update Form of Therapist</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <input type="hidden" name="therapist_id" value="<?php echo $therapist_id; ?>">
            
            <label for="therapist_id">Therapist ID:</label>
            <input type="number" name="therapist_id" value="<?php echo $therapist_id; ?>">
            <br><br>

            <label for="therapist_first_name">First Name:</label>
            <input type="text" name="therapist_first_name" value="<?php echo $therapist_first_name; ?>">
            <br><br>

            <label for="therapist_last_name">Last Name:</label>
            <input type="text" name="therapist_last_name" value="<?php echo $therapist_last_name; ?>">
            <br><br>

            <label for="specialization">Specialization:</label>
            <input type="text" name="specialization" value="<?php echo $specialization; ?>">
            <br><br>

            <label for="experience_years">Experience (Years):</label>
            <input type="number" name="experience_years" value="<?php echo $experience_years; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
            <p style="color: red;"><?php echo $update_status; ?></p>
        </form>
    </center>
</body>
</html>
