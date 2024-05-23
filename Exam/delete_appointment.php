<?php
    // Connection details
    include('database_connection.php');

    // Check if appointment_id is set
    if(isset($_REQUEST['appointment_id'])) {
        $appointment_id = $_REQUEST['appointment_id'];

        // Prepare and execute the DELETE statement for the appointments table
        $stmt = $connection->prepare("DELETE FROM appointments WHERE appointment_id=?");
        $stmt->bind_param("i", $appointment_id);

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Delete Record</title>
            <script>
                function confirmDelete() {
                    return confirm("Are you sure you want to delete this record?");
                }
            </script>
        </head>
        <body>
            <form method="post" onsubmit="return confirmDelete();">
                <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
                <input type="submit" value="Delete">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->execute()) {
                    echo "Record deleted successfully.<br><br>";
                    echo "<a href='appointments.php'>OK</a>"; // Assuming appointments.php is the page displaying appointment records
                } else {
                    echo "Error deleting data: " . $stmt->error;
                }
            }
            ?>
        </body>
        </html>
        <?php

        $stmt->close();
    } else {
        echo "appointment_id is not set.";
    }

    $connection->close();
?>
