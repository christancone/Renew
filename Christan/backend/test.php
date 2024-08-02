<?php
require_once 'DBConnector.php';
require_once 'User.php';

// Initialize database connection
$db = new DBConnector();
$pdo = $db->connect();

// Create an instance of the User class
$user = new User($pdo);

// Data for the new user
//$newUser = [
//    'role' => 'Pharmacist',
//    'username' => 'christan',
//    'password' => password_hash('newpassword', PASSWORD_DEFAULT), // Hash the password
//    'firstname' => 'New',
//    'lastname' => 'Pharmacist',
//    'email' => 'new.pharmacist@example.com',
//    'phonenumber' => '123-456-7890'
//];

// Add the new user
//$userId = $user->addUser($newUser);
//
//if ($userId) {
//    echo "New user added with ID: $userId";
//} else {
//    echo "Failed to add new user.";
//}

var_dump($user->getUser(1));

// Disconnect from the database
$db->disconnect();
