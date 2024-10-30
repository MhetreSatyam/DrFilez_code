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
include("db_connection.php");

// Retrieve form data
$name = $_POST['name'];

// Extract components from the "name" field
$nameComponents = explode(' ', $name);
$first_name = $nameComponents[1] ?? '';  // Assuming "Dr." is always present
$middle_name = $nameComponents[2] ?? '';
$last_name = $nameComponents[3] ?? '';

$username = $_POST['username'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$civil = $_POST['civil'];
$age = $_POST['age'];
$contact_number = $_POST['contact_number'];
$address = $_POST['address'];
$qualifications = $_POST['qualifications'];
$specialization = $_POST['specialization'];
$working_at = $_POST['working_at'];
$experience = $_POST['experience'];

$uploadDir = "uploads/";

if (isset($_FILES['degree_certificate']) && isset($_FILES['userPhoto'])) {
    // New files are uploaded
    $degree_certificate = $_FILES['degree_certificate']['name'];
    $userPhoto = $_FILES['userPhoto']['name'];

    // Move uploaded files to a directory
    move_uploaded_file($_FILES['degree_certificate']['tmp_name'], $uploadDir . $degree_certificate);
    move_uploaded_file($_FILES['userPhoto']['tmp_name'], $uploadDir . $userPhoto);
} elseif (empty($_FILES['degree_certificate']['name']) && empty($_FILES['userPhoto']['name'])) {
    // No new files uploaded, use existing files
    $userPhoto = 'uploads/' . $_POST['existingUserPhotoFileName']; 
    $degree_certificate = 'uploads/' . $_POST['existingDegreeCertificateFileName']; 
} else {
    // Files not uploaded successfully
    die("Error: Files not uploaded successfully.");
}

// Update user profile in the database
$sql = "UPDATE dr_profile SET
        first_name = ?,
        middle_name = ?,
        last_name = ?,
        username = ?,
        email = ?,
        gender = ?,
        civil = ?,
        age = ?,
        contact_number = ?,
        address = ?,
        qualifications = ?,
        specialization = ?,
        working_at = ?,
        experience = ?,
        degree_certificate = ?,
        userPhoto = ?
        WHERE username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssssssss", $first_name, $middle_name, $last_name, $username, $email, $gender, $civil, $age, $contact_number, $address, $qualifications, $specialization, $working_at, $experience, $degree_certificate, $userPhoto, $username);

if ($stmt->execute()) {
    // Successful update
    echo '<div style="font-size:3.5em;color:#3498db;font-weight:bold;">Profile updated successfully!</div>';
} else {
    // Failed update
    echo "Error updating profile: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
