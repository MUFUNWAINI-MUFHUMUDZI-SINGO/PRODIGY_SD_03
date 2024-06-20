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

// Retrieve contacts from database
$sql = "SELECT id, name, phone, email FROM contacts";
$result = $conn->query($sql);

// Check if there are contacts to display
if ($result->num_rows > 0) {
    $contacts = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $contacts = [];
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Contacts</title>
  <link rel="stylesheet" href="styles.css"> 
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery CDN -->
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      background-color: #f0f2f5;
    }

    .container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      margin-bottom: 20px;
      font-size: 24px;
      text-align: center;
    }

    .contact-list {
      list-style-type: none;
      padding: 0;
      margin-bottom: 20px;
    }

    .contact-list li {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .contact-list li:hover {
      background-color: #f0f0f0;
    }

    .contact-details {
      display: none;
      margin-top: 10px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .contact-details h2 {
      font-size: 18px;
      margin-bottom: 10px;
    }

    .contact-details p {
      margin-bottom: 5px;
    }

    .btn {
    padding: 12px 24px;
    margin: 10px;
    border: none;
    border-radius: 5px;
    background-color: #007bff; 
    color: white;
    font-size: 16px;
    text-decoration: none;
    cursor: pointer;
    display: inline-block;
    text-align: center;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3; 
}

.btn-delete {
    background-color: #dc3545; /* Red color for delete button */
}

.btn-delete:hover {
    background-color: #c82333; /* Darker shade of red on hover for delete button */
}

  </style>
  <script>
    $(document).ready(function() {
      $('.contact-list li').click(function() {
        var index = $(this).index();
        $('.contact-details').eq(index).toggle();
      });
    });
  </script>
</head>
<body>
  <div class="container">
    <h1>View Contacts</h1>
    <ul class="contact-list">
      <?php foreach ($contacts as $contact): ?>
        <li><?php echo htmlspecialchars($contact['name']); ?></li>
      <?php endforeach; ?>
    </ul>
    <?php foreach ($contacts as $contact): ?>
      <div class="contact-details">
        <h2><?php echo htmlspecialchars($contact['name']); ?></h2>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($contact['phone']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
        <a href="edit_contact.php?id=<?php echo $contact['id']; ?>" class="btn">Edit</a>
        <a href="delete_contact.php?id=<?php echo $contact['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this contact?')">Delete</a>
   
    </div>
    <?php endforeach; ?>
    <a href="Add.php" class="btn">Add New Contact</a>
    <a href="index.php" class="btn">Back to Home</a>
  </div>
</body>
</html>
