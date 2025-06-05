<?php
class Database {
    private static $connection = null;

    public static function get_env($name, $default) {
        return isset($_ENV[$name]) && trim($_ENV[$name]) !== "" ? $_ENV[$name] : $default;
    }

    public static function DB_HOST() {
        return self::get_env('DB_HOST', '127.0.0.1');
    }

    public static function DB_NAME() {
        return self::get_env('DB_NAME', 'ecommerceshop');
    }

    public static function DB_PORT() {
        return self::get_env('DB_PORT', 3306);
    }

    public static function DB_USER() {
        return self::get_env('DB_USER', 'root');
    }

    public static function DB_PASSWORD() {
        return self::get_env('DB_PASSWORD', 'root');
    }

    public static function JWT_SECRET() {
        return self::get_env('JWT_SECRET', 'b8e5d2c5d8f7c6d4a3e9e58e4d2f3c9261a7260b6e4f1b4b93c7f0c1a1b3c5d9');
    }

    

    public static function connect() {
        if (self::$connection === null) {
            try {
                $dsn = "mysql:host=" . self::DB_HOST() . ";dbname=" . self::DB_NAME() . ";port=" . self::DB_PORT();
                self::$connection = new PDO(
                    $dsn,
                    self::DB_USER(),
                    self::DB_PASSWORD(),
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

    
}
?>
