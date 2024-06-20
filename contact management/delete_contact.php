<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "CON"; 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize and validate input (to prevent SQL injection)
function sanitize_input($input) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags($input)));
}

// Check if contact ID is provided in URL parameter
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the ID to prevent SQL injection
    $contactId = sanitize_input($_GET['id']);

    // Prepare a delete statement
    $sql = "DELETE FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("i", $contactId);
        $stmt->execute();

        // Check if deletion was successful
        if ($stmt->affected_rows > 0) {
            // Contact deleted successfully
            echo "<script>alert('Contact deleted successfully.'); window.location.href = 'View.php';</script>";
        } else {
            // No rows affected, contact might not exist
            echo "<script>alert('Contact not found or could not be deleted.'); window.location.href = 'View.php';</script>";
        }

        // Close statement
        $stmt->close();
    } else {
        // Error preparing the statement
        echo "<script>alert('Error preparing statement: " . $conn->error . "'); window.location.href = 'View.php';</script>";
    }
} else {
    // ID parameter is missing or empty
    echo "<script>alert('Contact ID is missing or invalid.'); window.location.href = 'View.php';</script>";
}

// Close connection
$conn->close();
?>
