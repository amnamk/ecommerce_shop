<?php
require_once 'BaseDao.php';

class AdminDao extends BaseDao {
    public function __construct() {
        parent::__construct('admin');
    }

    public function insert($admin) {
        $sql = "INSERT INTO admin (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':name' => $admin['name'],
            ':email' => $admin['email'],
            ':password' => $admin['password']
        ]);
    }

    public function getAll() {
        $stmt = $this->connection->query("SELECT * FROM admin");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($admin_id) {
        $stmt = $this->connection->prepare("SELECT * FROM admin WHERE admin_id = :admin_id");
        $stmt->bindParam(':admin_id', $admin_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAdminByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE email = :email");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    
    public function delete($id) {
        return parent::delete($id);
    }

    public function update($id, $data) {
        return parent::update($id, $data);
    }

    public function getAllAdmins() {
        return parent::getAll();
    }

}
?>
