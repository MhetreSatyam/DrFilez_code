<?php
include("db_connection.php");

if (isset($_POST['search_term'])) {
    $searchTerm = $_POST['search_term'];

    // Modify your SQL query to filter based on the search term
    $sql = "SELECT * FROM dr_profile 
            WHERE first_name LIKE '%$searchTerm%' OR
                  last_name LIKE '%$searchTerm%' OR
                  specialization LIKE '%$searchTerm%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $doctors = array();

        while ($row = $result->fetch_assoc()) {
            // Include the 'userPhoto' field in the response
            $row['userPhoto'] = "uploads/" . $row['userPhoto'];
            $doctors[] = $row;
        }

        echo json_encode($doctors);
    } else {
        echo json_encode(array("message" => "No doctors found."));
    }
}
?>
