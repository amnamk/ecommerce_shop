<?php
require_once 'BaseDao.php';

class GeneralDao extends BaseDao {
    public function __construct() {
        parent::__construct('general'); 
    }

    
    public function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    
    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE general_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

   
    public function insert($general) {
        $sql = "INSERT INTO " . $this->table . " (title, author, description, image_url) 
                VALUES (:title, :author, :description, :image_url)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':title' => $general['title'],
            ':author' => $general['author'],
            ':description' => $general['description'],
            ':image_url' => $general['image_url']
        ]);
    }

    
    public function update($id, $data) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");
        $sql = "UPDATE " . $this->table . " SET $fields WHERE general_id = :id";
        $stmt = $this->connection->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

   
    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE general_id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
   
}
?>
