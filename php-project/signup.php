<?php
include("db_connection.php");

// Retrieve form data
$firstName = $_POST['name'];
$middleName = $_POST['middle_name'];
$lastName = $_POST['last_name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

// Check if password and confirm password match
if ($password !== $confirmPassword) {
    die("Error: Password and Confirm Password do not match.");
}

// Hash the password (recommended for security)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$q1 = $_POST['q1'];
$q2 = $_POST['q2'];
$gender = $_POST['gender'];
$civil = $_POST['civil'];
$age = $_POST['age'];
$contact = $_POST['contact'];
$qualifications = $_POST['qualifications'];
$address = $_POST['address'];
$working_at = $_POST['working_at'];
$specialization = $_POST['specialization'];
$experience = $_POST['experience'];


// File Upload Handling
if (isset($_FILES['degree_certificate']) && isset($_FILES['userPhoto'])) {
    $degreeCertificate = $_FILES['degree_certificate']['name'];
    $userPhoto = $_FILES['userPhoto']['name'];

    // Move uploaded files to a directory
    $uploadDir = "uploads/";
    move_uploaded_file($_FILES['degree_certificate']['tmp_name'], $uploadDir . $degreeCertificate);
    move_uploaded_file($_FILES['userPhoto']['tmp_name'], $uploadDir . $userPhoto);
} else {
    echo '<div style="font-size:5em;color:#0e3c68;font-weight:bold;">Error: Files not uploaded successfully.</div>';
}

// SQL query with prepared statement
$sql = "INSERT INTO dr_profile (first_name, middle_name, last_name, username, email, password, q1, q2, gender, civil, age, contact_number, qualifications, address, working_at, specialization, experience, degree_certificate, userPhoto)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssssssssss", $firstName, $middleName, $lastName, $username, $email, $hashedPassword, $q1, $q2, $gender, $civil, $age, $contact, $qualifications, $address, $working_at, $specialization, $experience, $degreeCertificate, $userPhoto);


if ($stmt->execute()) {
    echo '<div style="font-size:2.5em;color:#3498db;font-weight:bold;font-style:italic;">New record created successfully</div>';
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
