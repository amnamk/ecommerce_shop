<?php
require_once 'BaseService.php';
require_once  __DIR__ .'/../dao/UserDao.php';

class UserService extends BaseService {
   

    public function __construct() {
        $this->dao = new UserDao(); 
        parent::__construct($this->dao); 
    }

    public function getUserByEmail($email) {
        return $this->dao->getUserByEmail($email);
    }

    public function getAll(){
        return $this->dao->getAll();
    }

    public function insertUser($user) {
    if (isset($user['password'])) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
    }
    return $this->dao->insert($user);
   }


    public function getUserByRole($role) {
        return $this->dao->getUserByRole($role);
    }

    public function updatePassword($email, $newPassword) {
        return $this->dao->updatePassword($email, $newPassword);
    }

    public function delete($id) {
        return $this->dao->delete($id);
    }

    public function getByUserId($id) {
        return $this->dao->getByUserId($id);
    }

    public function updateUser($id, $data) {
        return $this->dao->update($id, $data);
    }

   



    

  
}
?>
