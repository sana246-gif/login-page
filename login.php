<?php
// Database configuration
$servername = "localhost";
$username = "Airex"; // Update with your database username
$password = "Pass123"; // Update with your database password
$dbname = "webapp"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$email = $_POST['qemail'];
$password = $_POST['qpassword'];

// Prepare and bind
$stmt = $conn->prepare("SELECT password FROM registration WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute the statement
$stmt->execute();
$stmt->store_result();

// Check if the user exists
if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Verify the password
    if (password_verify($password, $hashed_password)) {
        echo "Login successful! Welcome, " . $email;
        // Here, you can start a session or redirect the user to another page
    } else {
        echo "Invalid password. Please try again.";
    }
} else {
    echo "No user found with this email.";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
