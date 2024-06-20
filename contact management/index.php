<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Management</title>
<style>
 * {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

body {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f0f2f5;
}

.container {
  text-align: center;
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
  margin-bottom: 20px;
  font-size: 24px;
}

.button-group {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.btn {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  background-color: #007bff;
  color: white;
  font-size: 16px;
  text-decoration: none;
  text-align: center;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #0056b3;
}

@media (min-width: 600px) {
  .button-group {
    flex-direction: row;
  }

  .btn {
    margin: 0 10px;
  }
}

</style>
</head>
<body>
    <div class="container">
        <h1>Welcome to your <br><br><br>Contact Management System</h1>
        <div class="button-group">
          <a href="View.php" class="btn">View Contacts</a>
          <a href="Add.php" class="btn">Add Contact</a>
        </div>
      </div>


</body>
</html>
