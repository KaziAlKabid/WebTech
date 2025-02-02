<?php

class Database {
    private static $instance = null; // Singleton instance
    private $connection;

    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host=localhost;dbname=lawyer_management", // Your database credentials
                "root", // Database username
                "", // Database password
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $exception) {
            die("Database connection error: " . $exception->getMessage());
        }
    }

    // Method to get the single instance of the database connection
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Method to get the PDO connection
    public function getConnection() {
        return $this->connection;
    }
}
