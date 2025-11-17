<?php
class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;
    
    private $connection;
    private $error;
    
    public function __construct() {
        // Cargar configuración aquí
        require_once 'config/database.php';
        
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->dbname = DB_NAME;
        
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        
        try {
            $this->connection = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            throw new Exception("Error de conexión: " . $this->error);
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
}
?>