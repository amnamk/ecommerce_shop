<?php
require_once 'UserBusinessLogic.php';

class UserController {
    private $userBusinessLogic;

    public function __construct() {
        $this->userBusinessLogic = new UserBusinessLogic();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['email'])) {
                try {
                    $user = $this->userBusinessLogic->getUserByEmail($_GET['email']);
                    echo json_encode(['user' => $user]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } elseif (isset($_GET['role'])) {
                try {
                    $users = $this->userBusinessLogic->getUsersByRole($_GET['role']);
                    echo json_encode(['users' => $users]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                try {
                    $users = $this->userBusinessLogic->getAllUsers();
                    echo json_encode(['users' => $users]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
        
            if (empty($data['email']) || empty($data['password']) || empty($data['name'])) {
                echo json_encode(['error' => 'Email, password, and name are required.']);
                return;
            }
        
           
        
            if (empty($data['role'])) {
                $data['role'] = 'user'; 
            }
        
        
            try {
                $this->userBusinessLogic->createUser($data);
                echo json_encode(['message' => 'User created successfully.']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $data = $_POST;
            if (empty($data['id'])) {
                echo json_encode(['error' => 'User ID is required for deletion.']);
                return;
            }
    
            try {
                $this->userBusinessLogic->delete($data['id']);
                echo json_encode(['message' => 'User deleted successfully.']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $data = $_POST;
            
            if (isset($_POST['email']) && isset($_POST['newPassword'])) {
                $email = $_POST['email'];
                $newPassword = $_POST['newPassword'];

                
                if (empty($email) || empty($newPassword)) {
                    echo json_encode(['error' => 'Email and new password are required.']);
                    return;
                }

                try {
                    
                    $this->userBusinessLogic->updatePassword($email, $newPassword);
                    echo json_encode(['message' => 'Password updated successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'Email and new password are required.']);
            }
        }
        
        
    }
}
?>
