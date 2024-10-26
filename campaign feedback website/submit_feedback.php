<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campaign_feedback";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['feedback']) && !empty($_POST['rating']) && !empty($_POST['submission_time'])) {
        $id = sanitize_input($_POST['id']);
        $name = sanitize_input($_POST['name']);
        $email = sanitize_input($_POST['email']);
        $feedback = sanitize_input($_POST['feedback']);
        $rating = sanitize_input($_POST['rating']);
        $submission_time = sanitize_input($_POST['submission_time']);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO feedback (id, name, email, feedback, rating, submission_time) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssis", $id, $name, $email, $feedback, $rating, $submission_time);

        // Execute and check
        if ($stmt->execute()) {
            echo "New record created successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Please fill in all required fields.";
    }
}

// Close the connection
$conn->close();
?>
