<?php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("db_connection.php"); // Include your database connection script

    // Get values from the form
    $patientId = $_POST['patientId'];
    $patientName = $_POST['patientName'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $bloodGroup = $_POST['bloodGroup'];
    $aadharNo = $_POST['aadharNo'];
    $contactNo = $_POST['contactNo'];
    $econtactNo = $_POST['econtactNo'];
    $address = $_POST['address'];
    $medicalHistory = $_POST['medicalHistory'];

    // Update query with prepared statement
    $updateQuery = "UPDATE patients SET 
        patientName = COALESCE(?, patientName), 
        dob = COALESCE(?, dob), 
        age = COALESCE(?, age), 
        gender = COALESCE(?, gender), 
        bloodGroup = COALESCE(?, bloodGroup), 
        aadharNo = COALESCE(?, aadharNo), 
        contactNo = COALESCE(?, contactNo), 
        econtactNo = COALESCE(?, econtactNo), 
        address = COALESCE(?, address), 
        medicalHistory = COALESCE(?, medicalHistory) 
    WHERE patientId = ?";

    // Prepare the statement
    $stmt = $conn->prepare($updateQuery);

    // Bind parameters
    $stmt->bind_param("ssssssssssi", $patientName, $dob, $age, $gender, $bloodGroup, $aadharNo, $contactNo, $econtactNo, $address, $medicalHistory, $patientId);

    // Execute the update query
    if ($stmt->execute()) {
        echo '<div style="font-size:2.5em;color:#3498db;font-weight:bold;font-style:italic;">Record updated successfully</div>';
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
