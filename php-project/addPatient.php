<?php
// Database connection
include("db_connection.php");

// Retrieve form data
$patientName = $_POST["patientName"];
$dob = $_POST["dob"];
$age = $_POST["age"];
$gender = $_POST["gender"];
$bloodGroup = $_POST["bloodGroup"];
$aadharNo = $_POST["aadharNo"];
$contactNo = $_POST["contactNo"];
$econtactNo = $_POST["econtactNo"];
$address = $_POST["address"];
$medicalHistory = $_POST["medicalHistory"];
$doctorPrescription = $_POST["doctorPrescription"];
$healthInsurance = $_POST["healthInsurance"];
$addInfo = $_POST["addInfo"];

// File Upload Handling
if (isset($_FILES['medicalReport']) && isset($_FILES['photo']) && isset($_FILES['insurancePhoto'])) {
    $medicalReport = $_FILES["medicalReport"]["name"];
    $photo = $_FILES["photo"]["name"];
    $insurancePhoto = $_FILES["insurancePhoto"]["name"];

    // Move uploaded files to a directory
    $uploadDir = "uploads/";

    move_uploaded_file($_FILES['medicalReport']['tmp_name'], $uploadDir . $medicalReport);
    move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photo);
    move_uploaded_file($_FILES['insurancePhoto']['tmp_name'], $uploadDir . $insurancePhoto);
} else {
    die("Error: Files not uploaded successfully.");
}


// SQL query with prepared statement
$sql = "INSERT INTO patients (patientName, dob, age, gender, bloodGroup, contactNo, econtactNo, address, medicalHistory, medicalReport, doctorPrescription, healthInsurance, photo, insurancePhoto, addInfo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssssss", $patientName, $dob, $age, $gender, $bloodGroup, $contactNo, $econtactNo, $address, $medicalHistory, $medicalReport, $doctorPrescription, $healthInsurance, $photo, $insurancePhoto, $addInfo);


if ($stmt->execute()) {
    // Get the auto-incremented ID of the last inserted record
    $patientId = $stmt->insert_id;
    echo '<div style="font-size:2.5em;color:#686e7d;font-weight:bold;font-style:italic;">Patient added successfully.<br>Patient ID: <span style="font-size:1.25em;color:#0e3c68;font-weight:bold;">' . $patientId.'</span>Save the ID for future use.</div>';
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
