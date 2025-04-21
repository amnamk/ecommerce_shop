<?php
require_once 'FavoritesBusinessLogic.php';

class FavoritesController {
    private $favoritesBusinessLogic;

    public function __construct() {
        $this->favoritesBusinessLogic = new FavoritesBusinessLogic();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;

            try {
                $result = $this->favoritesBusinessLogic->insert($data);
                echo json_encode(['message' => 'Favorite added successfully.', 'data' => $result]);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            try {
                if (isset($_GET['user_id']) && isset($_GET['type'])) {
                    $userId = $_GET['user_id'];
                    $type = $_GET['type'];

                    if ($type === 'product') {
                        $favorites = $this->favoritesBusinessLogic->getFavoriteProducts($userId);
                    } elseif ($type === 'special') {
                        $favorites = $this->favoritesBusinessLogic->getFavoriteSpecialProducts($userId);
                    } elseif ($type === 'all') {
                        $favorites = $this->favoritesBusinessLogic->getAllFavorites($userId);
                    } else {
                        throw new Exception("Invalid type parameter.");
                    }

                    echo json_encode($favorites);
                } elseif (isset($_GET['user_id'])) {
                    $favorites = $this->favoritesBusinessLogic->getFavoritesByUserId($_GET['user_id']);
                    echo json_encode($favorites);
                } elseif (isset($_GET['product_id'])) {
                    $favorites = $this->favoritesBusinessLogic->getFavoriteByProductId($_GET['product_id']);
                    echo json_encode($favorites);
                } else {
                    echo json_encode(['error' => 'Missing required GET parameters.']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }

        
    }
}
?>
