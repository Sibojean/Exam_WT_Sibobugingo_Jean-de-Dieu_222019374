 <?php
include('database_connection.php');

if(isset($_GET['query'])) {
    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

// Define the columns to search in activities table
    $activityColumns = ['activity_id', 'activity_name', 'description', 'duration_minutes', 'client_id', 'session_id'];
    $sql = "SELECT * FROM activities WHERE ";
    foreach ($activityColumns as $column) {
        $sql .= "$column LIKE '%$searchTerm%' OR ";
    }
    $sql = rtrim($sql, "OR ");
    $result_activities = $connection->query($sql);

    // Search in the appointments table
    $sql = "SELECT * FROM appointments WHERE appointment_id LIKE '%$searchTerm%'";
    $result_appointments = $connection->query($sql);

    // Search in the client table
    $sql = "SELECT * FROM client WHERE client_id LIKE '%$searchTerm%'";
    $result_clients = $connection->query($sql);

    // Search in the chathistory table
    $sql = "SELECT * FROM chathistory WHERE message_id LIKE '%$searchTerm%'";
    $result_chathistory = $connection->query($sql);

    // Define the columns to search in files table
    $fileColumns = ['file_id', 'file_name', 'file_type', 'file_size', 'upload_date', 'client_id', 'session_id'];
    $sql = "SELECT * FROM files WHERE ";
    foreach ($fileColumns as $column) {
        $sql .= "$column LIKE '%$searchTerm%' OR ";
    }
    $sql = rtrim($sql, "OR ");
    $result_files = $connection->query($sql);

    // Define the columns to search in files table
    $assessmentformColumns = ['file_id', 'file_name', 'file_type', 'file_size', 'upload_date', 'client_id', 'session_id'];
    $sql = "SELECT * FROM files WHERE ";
    foreach ($assessmentformColumns as $column) {
        $sql .= "$column LIKE '%$searchTerm%' OR ";
    }
    $sql = rtrim($sql, "OR ");
    $result_files = $connection->query($sql);

    // Define the columns to search in files table
    $therapistColumns = ['therapist_id', 'therapist_first_name', 'therapist_last_name', 'specialization', 'experience_years'];
    $sql = "SELECT * FROM therapists WHERE ";
    foreach ($therapistColumns as $column) {
        $sql .= "$column LIKE '%$searchTerm%' OR ";
    }
    $sql = rtrim($sql, "OR ");
    $result_therapists = $connection->query($sql);

    // Search in the activities table
    $sql = "SELECT * FROM activities WHERE activity_id LIKE '%$searchTerm%'";
    $result_activities = $connection->query($sql);

    // Search in the sessions table
    $sql = "SELECT * FROM sessions WHERE session_id LIKE '%$searchTerm%'";
    $result_sessions = $connection->query($sql);

    // Define the columns to search in payments table
    $paymentColumns = ['payment_id', 'client_id', 'amount', 'payment_date'];
    $sql = "SELECT * FROM payments WHERE ";
    foreach ($paymentColumns as $column) {
        $sql .= "$column LIKE '%$searchTerm%' OR ";
    }
    $sql = rtrim($sql, "OR ");
    $result_payments = $connection->query($sql);

    // Search in the therapists table
    $sql = "SELECT * FROM therapists WHERE therapist_id LIKE '%$searchTerm%'";
    $result_therapists = $connection->query($sql);

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    echo "<h3>Assessment Forms:</h3>";
    if ($result_assessment->num_rows > 0) {
        while ($row = $result_workshop->fetch_assoc()) {
            echo "<p>Form ID: " . $row['form_id'] . "</p>";
        }
    } else {
        echo "<p>No assessment forms found matching the search term: " . $searchTerm . "</p>";
    }

    echo "<h3>Appointments:</h3>";
    if ($result_appointments->num_rows > 0) {
        while ($row = $result_appointments->fetch_assoc()) {
            echo "<p>Appointment ID: " . $row['appointment_id'] . "</p>";
        }
    } else {
        echo "<p>No appointments found matching the search term: " . $searchTerm . "</p>";
    }

    echo "<h3>Clients:</h3>";
    if ($result_clients->num_rows > 0) {
        while ($row = $result_clients->fetch_assoc()) {
            echo "<p>Client ID: " . $row['client_id'] . "</p>";
        }
    } else {
        echo "<p>No clients found matching the search term: " . $searchTerm . "</p>";
    }

    echo "<h3>Chat History:</h3>";
    if ($result_chathistory->num_rows > 0) {
        while ($row = $result_chathistory->fetch_assoc()) {
            echo "<p>Message ID: " . $row['message_id'] . "</p>";
        }
    } else {
        echo "<p>No chat history found matching the search term: " . $searchTerm . "</p>";
    }

    echo "<h3>Files:</h3>";
    if ($result_files->num_rows > 0) {
        while ($row = $result_files->fetch_assoc()) {
            echo "<p>File ID: " . $row['file_id'] . "</p>";
            echo "<p>File Name: " . $row['file_name'] . "</p>";
            echo "<p>File Type: " . $row['file_type'] . "</p>";
            echo "<p>File Size: " . $row['file_size'] . "</p>";
            echo "<p>Upload Date: " . $row['upload_date'] . "</p>";
            echo "<p>Client ID: " . $row['client_id'] . "</p>";
            echo "<p>Session ID: " . $row['session_id'] . "</p>";
        }
    } else {
        echo "<p>No files found matching the search term: " . $searchTerm . "</p>";
    }

    echo "<h3>Activities:</h3>";
    if ($result_activities->num_rows > 0) {
        while ($row = $result_activities->fetch_assoc()) {
            echo "<p>Activity ID: " . $row['activity_id'] . "</p>";
            echo "<p>Activity Name: " . $row['activity_name'] . "</p>";
            echo "<p>Description: " . $row['description'] . "</p>";
            echo "<p>Duration_minutes: " . $row['duration_minutes'] . "</p>";
            echo "<p>Client ID: " . $row['client_id'] . "</p>";
            echo "<p>Session ID: " . $row['session_id'] . "</p>";
        }
    } else {
        echo "<p>No Activities found matching the search term: " . $searchTerm . "</p>";
    }

    echo "<h3>Sessions:</h3>";
    if ($result_sessions->num_rows > 0) {
        while ($row = $result_sessions->fetch_assoc()) {
            echo "<p>Session ID: " . $row['session_id'] . "</p>";
        }
    } else {
        echo "<p>No sessions found matching the search term: " . $searchTerm . "</p>";
    }

    echo "<h3>Payments:</h3>";
    if ($result_payments->num_rows > 0) {
        while ($row = $result_payments->fetch_assoc()) {
            echo "<p>Payment ID: " . $row['payment_id'] . "</p>";
            echo "<p>Client ID: " . $row['client_id'] . "</p>";
            echo "<p>Amount: " . $row['amount'] . "</p>";
            echo "<p>Payment Date: " . $row['payment_date'] . "</p>";
        }
    } else {
        echo "<p>No payments found matching the search term: " . $searchTerm . "</p>";
    }

    echo "<h3>Therapists:</h3>";
    if ($result_payments->num_rows > 0) {
        while ($row = $result_payments->fetch_assoc()) {
            echo "<p>Therapist ID: " . $row['therapist_id'] . "</p>";
            echo "<p>Therapist_first_name: " . $row['therapist_first_name'] . "</p>";
            echo "<p>Therapist_last_name: " . $row['therapist_last_name'] . "</p>";
            echo "<p>Specialization: " . $row['specialization'] . "</p>";
            echo "<p>Experience_years: " . $row['experience_years'] . "</p>";
        }
    } else {
        echo "<p>No payments found matching the search term: " . $searchTerm . "</p>";
    }

    $connection->close();
} else {
    echo "No search term was provided.";
}
?>
