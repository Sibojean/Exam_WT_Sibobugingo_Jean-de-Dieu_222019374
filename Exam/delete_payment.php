<?php
    // Connection details
    include('database_connection.php');

    // Check if payment_id is set
    if(isset($_REQUEST['payment_id'])) {
        $pid = $_REQUEST['payment_id'];

        // Prepare and execute the DELETE statement for the payment table
        $stmt = $connection->prepare("DELETE FROM payments WHERE payment_id=?");
        $stmt->bind_param("i", $pid);

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
                <input type="hidden" name="payment_id" value="<?php echo $pid; ?>">
                <input type="submit" value="Delete">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($stmt->execute()) {
                    echo "Record deleted successfully.<br><br>";
                    echo "<a href='payments.php'>OK</a>"; // Assuming payments.php is the page displaying payment records
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
        echo "payment_id is not set.";
    }

    $connection->close();
?>
