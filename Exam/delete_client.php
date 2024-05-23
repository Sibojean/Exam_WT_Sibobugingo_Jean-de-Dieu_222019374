<?php
    // Connection details
    include('database_connection.php');

    // Check if client_id is set
    if(isset($_REQUEST['client_id'])) {
        $client_id = $_REQUEST['client_id'];

        // Prepare and execute the DELETE statement for the clients table
        $stmt = $connection->prepare("DELETE FROM client WHERE client_id=?");
        $stmt->bind_param("i", $client_id);

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
                <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                <input type="submit" value="Delete">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->execute()) {
                    echo "Record deleted successfully.<br><br>";
                    echo "<a href='clients.php'>OK</a>"; // Assuming clients.php is the page displaying client records
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
        echo "client_id is not set.";
    }

    $connection->close();
?>
