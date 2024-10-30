<?php
session_start();

include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_pw"])) {
    // Check if the user is authenticated (logged in)
    if (!isset($_SESSION["username"])) {
        // Redirect to login page or handle the situation accordingly
        header("Location: login.php"); // Replace with your login page URL
        exit();
    }
    
    // Retrieve form data
    $username = $_POST["username"];
    $oldPassword = $_POST["oldPassword"];
    $newPassword = $_POST["newPassword"];

    // Ensure the provided username matches the authenticated user
    if ($username != $_SESSION["username"]) {
        echo "Error: Unauthorized access"; // Handle unauthorized access
        exit();
    }
  
    // Get the user ID based on the username
    $sql = "SELECT id, password FROM dr_profile WHERE username = '$username'";
    $result = $conn->query($sql);
   
    if ($result === FALSE) {
        // Handle database query error
        echo "Error: Database query error - " . $conn->error;
    } elseif ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row["id"];
        $hashedPassword = $row["password"];
        
        if (password_verify($oldPassword, $hashedPassword)) {
            // Old password is correct, proceed to update the password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE dr_profile SET password = '$hashedNewPassword' WHERE id = $id";
    
            if ($conn->query($updateSql) === TRUE) {
                echo '<div style="font-size:2.5em;color:#3498db;font-weight:bold;font-style:italic;">Password updated successfully</div>';
            } else {
                echo '<div style="font-size:2.5em;color:#686e7d;font-weight:bold;font-style:italic;">Error updating password: <span style="font-size:1.25em;color:#0e3c68;font-weight:bold;">' . $conn->error.'</span><</div>';
            }
        } else {
            echo '<div style="font-size:2.5em;color:#686e7d;font-weight:bold;font-style:italic;">Error: Incorrect old password</div>';
        }
    } else {
        echo '<div style="font-size:2.5em;color:#686e7d;font-weight:bold;font-style:italic;">Error: User not found or database error</div>';
    }
    
} else {
    echo '<div style="font-size:2.5em;color:#686e7d;font-weight:bold;font-style:italic;">Invalid request</div>';
}

// Close the database connection
$conn->close();
?>
