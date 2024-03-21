<?php
session_start();

// Include database connection or configuration file
require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["request_id"]) && is_numeric($_POST["request_id"])) {
        $request_id = $_POST["request_id"];

        // Update the status in the database (assuming you have a column named 'status')
        $sql = "UPDATE request SET status = 'Transferred' WHERE request_id = $request_id";
        if ($conn->query($sql) === TRUE) {
            // Update session variable to mark as seen
            $_SESSION['seen'][$request_id] = true;
            echo "success";
        } else {
            echo "error";
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
