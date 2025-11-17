<?php
class Category {
    private $db;
    private $table = 'categories';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getAll() {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT * FROM " . $this->table . " ORDER BY name";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>