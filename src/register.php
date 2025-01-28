<?php
require 'test_db.php';  // Ensure the DB connection is included

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Input Validation
    if (empty($name) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        // Successful registration, redirect to login page
        header("Location: login.html");
        exit();
    } else {
        echo "Error in registration: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
