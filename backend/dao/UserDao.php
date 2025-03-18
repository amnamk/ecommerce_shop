<?php
require_once 'BaseDao.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct('users');
    }

    public function getUserByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function insertUser($user) {
        $existingUser = $this->getUserByEmail($user['email']);
        if ($existingUser) {
            return false;
        }
        return $this->insert($user); 
    }

    public function getUserByRole($role) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE role = :role");
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(); 
    }

    public function updatePassword($email, $newPassword) {
        
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    
        $sql = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
    
    
    

    }

?>
