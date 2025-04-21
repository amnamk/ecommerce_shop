<?php
require_once 'GeneralService.php';

class GeneralBusinessLogic {
    private $generalService;

    public function __construct() {
        $this->generalService = new GeneralService();
    }

    
    public function searchByTitle($title) {
        if (empty($title)) {
            throw new Exception('Title cannot be empty.');
        }

        
        $title = trim($title);
        
        
        $results = $this->generalService->searchByTitle($title);
        
        if (empty($results)) {
            throw new Exception('No records found for the provided title.');
        }

        return $results;
    }

    
    public function getByAuthor($author) {
        if (empty($author)) {
            throw new Exception('Author cannot be empty.');
        }

        
        $author = trim($author);
        
        $results = $this->generalService->getByAuthor($author);
        
        if (empty($results)) {
            throw new Exception('No records found for the provided author.');
        }

        return $results;
    }

    public function createEntry($data): bool {
        if (empty($data['title']) || empty($data['author'])) {
            throw new Exception('Both title and author are required.');
        }

        return $this->generalService->create($data); 
    }


}
?>
