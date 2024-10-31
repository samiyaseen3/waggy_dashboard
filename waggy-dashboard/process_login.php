<?php
session_start(); 
require_once 'model/User.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    $user = new User(); 

    
    $loginResult = $user->login($email, $password);

    if ($loginResult === "success login") {
      
        $userDetails = $user->getUserByEmail($email);

        $_SESSION['user_id'] = $userDetails['user_id'];
        $_SESSION['user_email'] = $email; 
        $_SESSION['user_role'] = $userDetails['user_role']; 
        

        // Redirect to index.php for both Admin and Super Admin
        header("Location: index.php");
        exit();
    } else {
        // Login failed, set an error message
        $_SESSION['error_message'] = $loginResult; // Store error message in session
        header("Location: login.php"); // Redirect back to the login page
        exit();
    }
} else {
    // If the request method is not POST, redirect to the login page
    header("Location: login.php");
    exit();
}
