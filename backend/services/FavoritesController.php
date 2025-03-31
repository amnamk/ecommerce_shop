<?php
require_once 'FavoritesBusinessLogic.php';

class FavoritesController {
    private $favoritesBusinessLogic;

    public function __construct() {
        $this->favoritesBusinessLogic = new FavoritesBusinessLogic();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['user_id'])) {
                try {
                    $favorites = $this->favoritesBusinessLogic->getFavoritesByUserId($_GET['user_id']);
                    echo json_encode(['message' => 'Favorites retrieved successfully.', 'data' => $favorites]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } elseif (isset($_GET['product_id'])) {
                try {
                    $favoriteProduct = $this->favoritesBusinessLogic->getFavoriteByProductId($_GET['product_id']);
                    echo json_encode(['message' => 'Favorite product retrieved successfully.', 'data' => $favoriteProduct]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } elseif (isset($_GET['all'])) {
                try {
                    $favorites = $this->favoritesBusinessLogic->getAllFavorites($_GET['user_id']);
                    echo json_encode(['message' => 'All favorites retrieved successfully.', 'data' => $favorites]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'Invalid parameters.']);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $data = $_POST;
            if (empty($_POST['id'])) {
                echo json_encode(['error' => 'Favorite ID is required for deletion.']);
                return;
            }

            try {
                $this->favoritesBusinessLogic->delete($_POST['id']);
                echo json_encode(['message' => 'Favorite item deleted successfully.']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }

      
            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                $data = $_POST;
                if (empty($data['user_id'])) {
                    echo json_encode(['error' => 'User ID cannot be empty.']);
                    return;
                }
    
                
                if (empty($data['product_id']) && empty($data['specialproduct_id'])) {
                    echo json_encode(['error' => 'Either Product ID or Special Product ID must be provided.']);
                    return;
                }
    
                
                try {
                    
                    $result = $this->favoritesBusinessLogic->insert($data);
    
                    
                    echo json_encode(['message' => 'Favorite added successfully.', 'data' => $result]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            }
        }
    }

?>
