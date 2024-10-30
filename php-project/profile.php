<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to the login page if not logged in
    header("Location: index.html");
    exit();
}

// Retrieve the username from the session
$username = $_SESSION["username"];

// Database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "drfilez";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// include("db_connection.php");


// Perform query to fetch user data based on the username
$sql = "SELECT * FROM dr_profile WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User data found, fetch the information
    $row = $result->fetch_assoc();

    // Close the prepared statement
    $stmt->close();

    // Return user data
    $userData = [
        'name' => 'Dr. ' . $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'],
        'username' => $row['username'],
        'email' => $row['email'],
        'gender' => $row['gender'],
        'civil' => $row['civil'],
        'age' => $row['age'],
        'contact_number' => $row['contact_number'],
        'qualifications' => $row['qualifications'],
        'address' => $row['address'],
        'working_at' => $row['working_at'],
        'specialization' => $row['specialization'],
        'experience' => $row['experience'],
        'degree_certificate' => $row['degree_certificate'],
        'userPhoto' => $row['userPhoto']
    ];

    echo json_encode($userData);
} else {
    // User not found, return an empty array
    echo json_encode([]);
}

$conn->close();
