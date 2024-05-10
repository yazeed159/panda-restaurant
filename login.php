<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define the valid credentials
    $validUsername = "admin";
    $validPassword = "admin123";

    // Retrieve the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate the credentials
    if ($username === $validUsername && $password === $validPassword) {
        // Redirect to the admin dashboard page upon successful login
        header("Location: admin.php");
        exit;
    } else {
        // Invalid credentials, display an error message or redirect back to the login page
        echo "Invalid username or password";
    }
}
?>
