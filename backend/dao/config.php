<?php
class Database {
   private static $host = '127.0.0.1';
   private static $dbName = 'ecommerceshop';
   private static $username = 'root';
   private static $password = 'root';
   private static $connection = null;
   


   public static function connect() {
       if (self::$connection === null) {
           try {
               self::$connection = new PDO(
                   "mysql:host=" . self::$host . ";dbname=" . self::$dbName,
                   self::$username,
                   self::$password,
                   [
                       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                   ]
               );
           } catch (PDOException $e) {
               die("Connection failed: " . $e->getMessage());
           }
       }
       return self::$connection;
   }
   public static function JWT_SECRET() {
    return 'b8e5d2c5d8f7c6d4a3e9e58e4d2f3c9261a7260b6e4f1b4b93c7f0c1a1b3c5d9
';
}

}
?>
