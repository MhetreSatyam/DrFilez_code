<?php
session_start();

// Include the database connection file
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $q1 = $_POST["q1"];
    $q2 = $_POST["q2"];
    $newPassword = $_POST["password"];

    // Fetch user data from the dr_profile table
    $sql = "SELECT * FROM dr_profile WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify answers to security questions
        if ($row["q1"] == $q1 && $row["q2"] == $q2) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $updateSql = "UPDATE dr_profile SET password = '$hashedPassword' WHERE username = '$username'";
            if ($conn->query($updateSql) === TRUE) {
                echo '<div style="font-size:2.5em;color:#3498db;font-weight:bold;font-style:italic;">Password changed successfully.</div>';
            } else {
                echo '<div style="font-size:2.5em;color:#FF0000;font-weight:bold;font-style:italic;">Error updating password.</div>';
            }
        } else {
            echo '<div style="font-size:2.5em;color:#FF0000;font-weight:bold;font-style:italic;">Incorrect security question answers.</div>';
        }
    } else {
        echo '<div style="font-size:2.5em;color:#FF0000;font-weight:bold;font-style:italic;">User not found.</div>';
    }
} else {
    echo '<div style="font-size:2.5em;color:#FF0000;font-weight:bold;font-style:italic;">Invalid request.</div>';
}

// Close the database connection
$conn->close();
?>
