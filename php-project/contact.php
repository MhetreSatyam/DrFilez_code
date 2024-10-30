<?php

// Database connection
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the form
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $satisfaction = isset($_POST["satisfaction"]) ? 1 : 0;



// SQL query with prepared statement
$sql = "INSERT INTO contact_form (name, email, phone, subject, message, satisfaction)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $email, $phone, $subject, $message, $satisfaction);


if ($stmt->execute()) {
    echo '<div style="font-size:2.5em;color:#3498db;font-weight:bold;font-style:italic;">Feedback sent successfully</div>';
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
}
$conn->close();
?>
