<?php
require_once 'BaseService.php';
require_once 'GeneralDao.php';

class GeneralService extends BaseService {


    public function __construct() {
        $this->dao = new GeneralDao();  
        parent::__construct($this->dao);  
    }


    public function searchByTitle($title) {
        return $this->dao->searchByTitle($title);
    }

    public function getByAuthor($author) {
        return $this->dao->getByAuthor($author);
    }
}
?>
