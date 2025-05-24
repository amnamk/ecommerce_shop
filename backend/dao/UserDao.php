<?php
require_once 'BaseDao.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct('users', 'user_id'); 
    }

    
    public function getUserByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function insertUser($user) {
        $existingUser = $this->getUserByEmail($user['email']);
        if ($existingUser) {
            return false;
        }
    
        $success = $this->insert($user);
        return $success ? $this->connection->lastInsertId() : false;
    }
    

    public function getUserByRole($role) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE role = :role");
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($result)) {
            echo "No users found with role: $role\n";
        }
        
        return $result; 
    }
    
    

    
    public function updatePassword($email, $newPassword) {
        
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        
        $sql = "UPDATE " . $this->table . " SET password = :password WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }


    public function getByUserId($id) {
    $stmt = $this->connection->prepare(
        "SELECT * FROM " . $this->table . " WHERE " . $this->primaryKey . " = :id"
    );
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateUser($id, $data) {
    $fields = [];
    $params = [':id' => $id];
 
     unset($data['id']);
    if (isset($data['email'])) {
        $fields[] = "email = :email";
        $params[':email'] = $data['email'];
    }
    if (isset($data['name'])) {
        $fields[] = "name = :name";
        $params[':name'] = $data['name'];
    }
    if (isset($data['role'])) {
        $fields[] = "role = :role";
        $params[':role'] = $data['role'];
    }
    

    if (empty($fields)) {
        return false;  
    }

    $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE user_id = :id";
    $stmt = $this->connection->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    return $stmt->execute();
}




    


   
}
?>
