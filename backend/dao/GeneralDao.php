<?php
require_once 'BaseDao.php';

class GeneralDao extends BaseDao {
    public function __construct() {
        parent::__construct('general', 'general_id');
    }

    
    public function searchByTitle($title) {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE title LIKE :title");
        $stmt->bindValue(':title', '%' . $title . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getByAuthor($author) {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE author = :author");
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
?>
