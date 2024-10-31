<?php
require_once 'model/User.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User(); // Create a new User object

    // Check for create user action
    if (isset($_POST['newEmail'])) {
        // First, check if the email already exists
        if ($user->emailExists($_POST['newEmail'])) {
            $_SESSION['sweetalert'] = [
                "type" => "warning",
                "message" => "This email is already in use."
            ];
            // Optionally, you can redirect back to the form with an error message
             header("Location: users.php");
            exit; // Stop further processing
        }

        // Prepare data for user creation
        $data = [
            'first_name' => $_POST['newFirstName'],
            'last_name' => $_POST['newLastName'],
            'email' => $_POST['newEmail'],
            'password' => $_POST['newPassword'], // Consider hashing this password
            'gender' => $_POST['newGender'],
            'birth_date' => $_POST['newBirthDate'],
            'phone' => $_POST['newPhone'],
            'address' => $_POST['newAddress'],
            'state' => $_POST['newState'],
            'role' => $_POST['newRole']
        ];

        // Attempt to create a new user
        if ($user->createUser($data)) {
            $_SESSION['sweetalert'] = [
                "type" => "success",
                "message" => "User updated successfully!"
            ];
        } else {
            $_SESSION['sweetalert'] = [
                "type" => "error",
                "message" => "Failed to update User."
            ];
        }
        header("Location: users.php");
        exit();
    }

    // Check for delete user action
    if (isset($_POST['deleteUserId'])) {
        $user_id = $_POST['deleteUserId'];

        // Attempt to soft delete the user
        if ($user->softDeleteUser($user_id)) {
            $_SESSION['sweetalert'] = [
                "type" => "success",
                "message" => "User deleted successfully!"
            ];
        }else{
            $_SESSION['sweetalert'] = [
                "type" => "error",
                "message" => "Failed to delete user."
            ];
        }
        header("Location: users.php");
        exit();
    }

    // Check for edit user action
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the editUserId is set to determine if it's an update request
        if (isset($_POST['editUserId'])) {
            // Retrieve the user ID
            $userId = $_POST['editUserId'];
    
            // Fetch the current user data to retain the role
            $currentUser = $user->getUserById($userId); // Ensure you have a method to get user by ID
            
            // Check if the user exists
            if ($currentUser) {
                // Prepare the data for update
                $data = [
                    'user_id' => $userId,
                    'first_name' => $_POST['editFirstName'],
                    'last_name' => $_POST['editLastName'],
                    'email' => $_POST['editEmail'],
                    'gender' => $_POST['editGender'],
                    'birth_date' => $_POST['editBirthDate'],
                    'phone' => $_POST['editPhone'],
                    'address' => $_POST['editAddress'],
                    'state' => $_POST['editState'],
                    // Use the current role to prevent admin from changing it
                    'role' => $currentUser['user_role'] // Retain the existing role
                ];
    
                // Attempt to update the user
                if ($user->updateUser($data)) {
                    $_SESSION['sweetalert'] = [
                        "type" => "success",
                        "message" => "User updated successfully!"
                    ];
                } else {
                    $_SESSION['sweetalert'] = [
                        "type" => "error",
                        "message" => "Failed to update user."
                    ];
                }
            } else {
                $_SESSION['sweetalert'] = [
                    "type" => "error",
                    "message" => "User not found."
                ];
            }
    
            header("Location: users.php");
            exit();
        }
    }
}
