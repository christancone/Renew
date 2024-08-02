<?php
class User {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
        public function addUser($data) {
            try {
                $sql = "INSERT INTO users (role, username, password, firstname, lastname, email, phonenumber) 
                    VALUES (:role, :username, :password, :firstname, :lastname, :email, :phonenumber)";
                $stmt = $this->pdo->prepare($sql);

                // Binding parameters
                $stmt->bindParam(':role', $data['role']);
                $stmt->bindParam(':username', $data['username']);
                $stmt->bindParam(':password', $data['password']);
                $stmt->bindParam(':firstname', $data['firstname']);
                $stmt->bindParam(':lastname', $data['lastname']);
                $stmt->bindParam(':email', $data['email']);
                $stmt->bindParam(':phonenumber', $data['phonenumber']);

                // Execute the statement
                $stmt->execute();

                return $this->pdo->lastInsertId();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false;
            }
    }

    public function updateUser($id, $data) {
        try {
            $sql = "UPDATE users SET role = :role, username = :username, password = :password, firstname = :firstname, lastname = :lastname, email = :email, phonenumber = :phonenumber WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);

            // Binding parameters
            $stmt->bindParam(':role', $data['role']);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->bindParam(':firstname', $data['firstname']);
            $stmt->bindParam(':lastname', $data['lastname']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phonenumber', $data['phonenumber']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function deleteUser($id) {
        // SQL and logic to delete user
    }

    public function getUser($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);

            // Binding the ID parameter
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            // Fetch the user data
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user ? $user : null;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



    public function getAllUsers() {
        // SQL and logic to retrieve all users
    }
}
