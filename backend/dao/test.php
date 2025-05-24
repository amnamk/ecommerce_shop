<?php
require_once 'config.php';  // Your DB connection setup (should define $pdo or similar)
require_once 'UserDao.php'; // Your UserDao class

$testUserId = 25; // Change to a valid user ID in your DB

// New data to update
$updateData = [
    'email' => 'newemail@example.com',
    'name'  => 'Updated User Name',
    'role'  => 'admin'  // Or whatever role you want to test
];

$userDao = new UserDao();

// Attempt to update user
$success = $userDao->updateUser($testUserId, $updateData);

if ($success) {
    echo "User updated successfully.\n";

    // Optionally fetch and display the updated user info
    $updatedUser = $userDao->getByUserId($testUserId);
    echo "Updated user data:\n<pre>";
    print_r($updatedUser);
    echo "</pre>";
} else {
    echo "Failed to update user. Either user does not exist or no data was provided to update.\n";
}
?>
