<?php
// Start the session
session_start();

// Check if the data is sent
if ($_SERVER['REQUEST_METHOD'] ?? '' === 'POST') {
    // Get the JSON data
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Set the session variable
    $_SESSION['patientId'] = $data['patientId'];

    // Respond with success
    echo json_encode(array('success' => true));
} else {
    // Respond with an error if the request method is not POST
    echo json_encode(array('success' => false, 'message' => 'Invalid request method.'));
}
