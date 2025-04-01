<?php
require_once 'GeneralDao.php';

$generalDao = new GeneralDao();


$titleResults = $generalDao->searchByTitle('Sample Title');
print_r($titleResults);


$authorResults = $generalDao->getByAuthor('Author One');
print_r($authorResults);

$data = [
    'title' => 'Title Something',
    'author' => 'John Doe',
    'description' => 'This is a description of the sample record.',
    'image_url' => 'https://example.com/image.jpg'
];


if ($generalDao->insert($data)) {
    echo "Record inserted successfully!";
} else {
    echo "Failed to insert record.";
}
?>
