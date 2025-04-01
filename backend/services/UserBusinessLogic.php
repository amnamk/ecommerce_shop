<?php
require_once 'UserService.php';

class UserBusinessLogic {
    private $userService;
    
    public function __construct() {
        $this->userService = new UserService();
    }
    
    public function createUser($user) {
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }
        
        if (strlen($user['password']) < 6) {
            throw new Exception('Password must be at least 6 characters long.');
        }

        
        
        return $this->userService->insertUser($user);
    }
    
    public function getUserByEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }
        
        return $this->userService->getUserByEmail($email);
    }
    
    public function getUsersByRole($role) {
        if (empty($role)) {
            throw new Exception('Role cannot be empty.');
        }
        
        return $this->userService->getUserByRole($role);
    }
    
    public function updatePassword($email, $newPassword) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }
        
        if (strlen($newPassword) < 6) {
            throw new Exception('Password must be at least 6 characters long.');
        }
        
        return $this->userService->updatePassword($email, $newPassword);
    }

    public function getAllUsers() {
        return $this->userService->getAll(); 
    }

    public function delete($id) {
        return $this->userService->delete($id); 
    }
}
