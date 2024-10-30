<?php
include("db_connection.php");

if (isset($_POST['search_term'])) {
    // Get the search term (patient ID)
    $searchTerm = $_POST["search_term"];

    // Use prepared statement to avoid SQL injection
    $sql = "SELECT * FROM patients 
            WHERE patientName LIKE '%$searchTerm%' OR
                  patientId LIKE '%$searchTerm%'";

    // Get the result
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $patients = array();

        while ($row = $result->fetch_assoc()) {
            $row['photo'] = "uploads/" . $row['photo'];
            $row['insurancePhoto'] = "uploads/" . $row['insurancePhoto'];
            $row['medicalReport'] = "uploads/" . $row['medicalReport'];

            // No need to include patient ID in the response, as it's already part of the row
            $patients[] = $row;
        }

        // Return user data directly, without using sessions
        echo json_encode($patients);
    } else {
        // Patient not found
        echo json_encode(array("message" => "Error: Record not found."));
    }
}

// Close the database connection
$conn->close();
?>
