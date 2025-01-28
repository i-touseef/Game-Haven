<?php
require 'test_db.php';  // Ensure the DB connection is included

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Email or Password cannot be empty!";
        exit();
    }

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];

            // Redirect to the homepage
            header("Location: index.html");
            exit();
        } else {
            echo "Invalid password! <a href='login.html'>Try again</a>";
        }
    } else {
        echo "User not found! <a href='register.html'>Register here</a>";
    }

    $stmt->close();
}
$conn->close();
?>
