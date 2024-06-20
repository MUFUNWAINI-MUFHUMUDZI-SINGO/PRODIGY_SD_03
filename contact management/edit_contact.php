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

// Initialize variables
$name = $phone = $email = "";
$errors = [];

// Check if contact ID is provided in URL parameter
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the ID to prevent SQL injection
    $contactId = sanitize_input($_GET['id']);

    // Fetch contact details from database based on $contactId
    $sql = "SELECT id, name, phone, email FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameter and execute statement
        $stmt->bind_param("i", $contactId); // 'i' indicates integer type
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if contact exists
        if ($result->num_rows > 0) {
            // Fetch contact details
            $contact = $result->fetch_assoc();
            $name = $contact['name'];
            $phone = $contact['phone'];
            $email = $contact['email'];
        } else {
            // Contact not found
            $errors[] = "Contact not found.";
        }

        // Close statement
        $stmt->close();
    } else {
        // Error preparing the statement
        $errors[] = "Error preparing statement: " . $conn->error;
    }
} else {
    // ID parameter is missing or empty
    $errors[] = "Contact ID is missing or invalid.";
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $name = sanitize_input($_POST['name']);
    $phone = sanitize_input($_POST['phone']);
    $email = sanitize_input($_POST['email']);

    // Update contact in database
    $sql = "UPDATE contacts SET name = ?, phone = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute statement
        $stmt->bind_param("sssi", $name, $phone, $email, $contactId); // 's' indicates string type, 'i' indicates integer type
        $stmt->execute();

        // Check if update was successful
        if ($stmt->affected_rows > 0) {
            // Redirect to view contacts page after successful update
            header("Location: View.php");
            exit;
        } else {
            // No rows affected, contact might not exist
            $errors[] = "Contact not found or could not be updated.";
        }

        // Close statement
        $stmt->close();
    } else {
        // Error preparing the statement
        $errors[] = "Error preparing statement: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Contact</title>
  <link rel="stylesheet" href="styles.css"> 
  <style>
   
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}


body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}


.container {
    width: 100%;
    max-width: 500px;
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}


h1 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
}


form {
    display: grid;
    gap: 15px;
}

.form-group {
    display: grid;
    gap: 5px;
}

label {
    font-weight: bold;
}

input[type="text"],
input[type="tel"],
input[type="email"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}
.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    text-decoration: none;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.3s ease;
    display: inline-block;
}

.btn-primary {
    background-color: #007bff; 
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3; 
}

.btn-orange {
    background-color: #ff9800; 
    color: white;
}

.btn-orange:hover {
    background-color: #f57c00; 
}



.errors {
    margin-bottom: 15px;
    padding: 10px;
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    border-radius: 5px;
}

.errors ul {
    list-style-type: none;
    padding-left: 0;
}

.errors li {
    margin-bottom: 5px;
}

  </style>
</head>
<body>
  <div class="container">
    <h1>Edit Contact</h1>

    <?php if (!empty($errors)): ?>
      <div class="errors">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $contactId); ?>" method="post">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
      </div>
      <button type="submit" class="btn">Update Contact</button>
    </form>

    <a href="View.php" class="btn">Back to Contacts</a>
  </div>
</body>
</html>
