<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


require __DIR__ . '/../../../vendor/autoload.php';


if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    define('BASE_URL', 'http://localhost/web_ecommerce_shop/backend');
} else {
    define('BASE_URL' , 'https://urchin-app-a8zw7.ondigitalocean.app/backend/');
}


$openapi = \OpenApi\Generator::scan([
    __DIR__ . '/doc_setup.php', 
    __DIR__ . '/../../../routes' 
]);


header('Content-Type: application/json');


echo $openapi->toJson();

?>
