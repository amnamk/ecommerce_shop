<?php
require_once 'BaseService.php';
require_once 'UserDao.php';

class UserService extends BaseService {
   

    public function __construct() {
        $this->dao = new UserDao(); 
        parent::__construct($this->dao); 
    }

    public function getUserByEmail($email) {
        return $this->dao->getUserByEmail($email);
    }

    public function insertUser($user) {
        return $this->dao->insertUser($user);
    }

    public function getUserByRole($role) {
        return $this->dao->getUserByRole($role);
    }

    public function updatePassword($email, $newPassword) {
        return $this->dao->updatePassword($email, $newPassword);
    }

    

  
}
?>
