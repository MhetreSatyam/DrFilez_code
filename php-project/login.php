<?php

include("db_connection.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the login form
    $usernameOrEmail = $_POST["name"];
    $password = $_POST["password"];

    // Perform query to check if the user exists in the database
    $sql = "SELECT * FROM dr_profile WHERE (username = '$usernameOrEmail' OR email = '$usernameOrEmail')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User is found, verify the password
        $row = $result->fetch_assoc();
        $hashedPasswordFromDatabase = $row['password'];

        if (password_verify($password, $hashedPasswordFromDatabase)) {
            // Password is correct, perform login
            session_start();
            $_SESSION["username"] = $usernameOrEmail;
            // Redirect to the dashboard page
            header("Location: dashboard(Profile).html");
            exit();
        } else {
            // Incorrect password
            echo '<div style="font-size:2.5em;color:#686e7d;font-weight:bold;font-style:italic;">Invalid login credentials. Please check your username/email and password.</div>';
            exit();
        }
    } else {
        // User not found, display error message
        echo '<div style="font-size:2.5em;color:#686e7d;font-weight:bold;font-style:italic;">Invalid login credentials. Please check your username/email and password.</div>';
        exit();
    }
}

$conn->close();
?>
