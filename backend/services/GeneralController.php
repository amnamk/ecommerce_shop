<?php
require_once 'GeneralBusinessLogic.php';

class GeneralController {
    private $generalBusinessLogic;

    public function __construct() {
        $this->generalBusinessLogic = new GeneralBusinessLogic();
    }

    public function handleRequest() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['title'])) {
                
                try {
                    $title = $_GET['title'];
                    $results = $this->generalBusinessLogic->searchByTitle($title);
                    echo json_encode(['message' => 'Search results by title', 'data' => $results]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } elseif (isset($_GET['author'])) {
                
                try {
                    $author = $_GET['author'];
                    $results = $this->generalBusinessLogic->getByAuthor($author);
                    echo json_encode(['message' => 'Search results by author', 'data' => $results]);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['error' => 'Title or Author is required for search.']);
            }
        }

        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = $_POST;

            
            if (empty($data['title']) || empty($data['author'])) {
                echo json_encode(['error' => 'Both title and author are required to create an entry.']);
                return;
            }

            try {
                
                $result = $this->generalBusinessLogic->createEntry($data);
                echo json_encode(['message' => 'Entry created successfully.', 'data' => $result]);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }
    }
}
?>
