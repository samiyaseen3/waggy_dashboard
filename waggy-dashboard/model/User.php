<?php
require_once 'Database.php';


class User {
    private $conn;
    private $table_name = "users";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Function to get all users
    public function getAllUsers() {
        $query = "
             SELECT * 
             FROM users 
             WHERE is_deleted = 0 AND user_role IN ('Admin', 'User')
             ;
             "; 

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // Function to soft delete a user
    public function softDeleteUser($user_id) {
        $query = "UPDATE " . $this->table_name . " SET is_deleted = 1 WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    // Other existing methods...

    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE user_email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; // Return true if email exists
    }

    public function createUser($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_first_name, user_last_name, user_email, user_password, user_gender, user_birth_of_date, user_phone_number, user_address_line_one, user_state, user_role) 
                  VALUES (:first_name, :last_name, :email, :password, :gender, :birth_date, :phone, :address, :state, :role)";
    
        $stmt = $this->conn->prepare($query);
    
        // Hash the password before storing it
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
    
        // Bind parameters
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashedPassword); // Use the hashed password
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':birth_date', $data['birth_date']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':state', $data['state']);
        $stmt->bindParam(':role', $data['role']);
    
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }
    
    public function updateUser($data) {
        $query = "UPDATE " . $this->table_name . " SET 
                  user_first_name = :first_name, 
                  user_last_name = :last_name, 
                  user_email = :email, 
                  user_gender = :gender, 
                  user_birth_of_date = :birth_date, 
                  user_phone_number = :phone, 
                  user_address_line_one = :address, 
                  user_state = :state, 
                  user_role = :role 
                  WHERE user_id = :user_id";
    
        $stmt = $this->conn->prepare($query);
    
        // Bind parameters
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':birth_date', $data['birth_date']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':state', $data['state']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':user_id', $data['user_id']); // Bind user_id for the WHERE clause
    
        return $stmt->execute(); // Execute and return true/false
    }

    public function login($email, $password) {
        // Assuming you have a method to fetch user data based on email
        $userData = $this->getUserByEmail($email); // Replace with actual method
    
        if ($userData) {
            // Check if the password is correct
            if (password_verify($password, $userData['user_password'])) {
                // Check if the user role is Admin or Super Admin
                if ($userData['user_role'] === 'Admin' || $userData['user_role'] === 'Superadmin') {
                    return "success login"; // Successful login
                } else {
                    return "Unauthorized access: You do not have permission to log in."; // Not an Admin or Super Admin
                }
            } else {
                return "Invalid password."; // Incorrect password
            }
        } else {
            return "User not found."; // No user with that email
        }
    }
    

    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserById($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = :user_id AND is_deleted = 0");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
    
    
    
    
    
    
}
?>