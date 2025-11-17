<?php
class Product {
    private $db;
    private $table = 'products';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getAll() {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT p.*, c.name as category_name 
                FROM " . $this->table . " p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getFeatured() {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT p.*, c.name as category_name 
                FROM " . $this->table . " p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.featured = TRUE 
                ORDER BY p.created_at DESC 
                LIMIT 6";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByCategory($category_id) {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT p.*, c.name as category_name 
                FROM " . $this->table . " p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :category_id 
                ORDER BY p.created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['category_id' => $category_id]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT p.*, c.name as category_name 
                FROM " . $this->table . " p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $conn = $this->db->getConnection();
        
        $sql = "INSERT INTO " . $this->table . " 
                (name, description, price, stock, category_id, processor, ram, storage, graphics_card, screen_size, amazon_link, image_url, featured) 
                VALUES (:name, :description, :price, :stock, :category_id, :processor, :ram, :storage, :graphics_card, :screen_size, :amazon_link, :image_url, :featured)";
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute($data);
    }
    
    public function update($id, $data) {
        $conn = $this->db->getConnection();
        
        $sql = "UPDATE " . $this->table . " 
                SET name = :name, description = :description, price = :price, stock = :stock, 
                    category_id = :category_id, processor = :processor, ram = :ram, 
                    storage = :storage, graphics_card = :graphics_card, screen_size = :screen_size,
                    amazon_link = :amazon_link, image_url = :image_url, featured = :featured 
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    public function delete($id) {
        $conn = $this->db->getConnection();
        
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute(['id' => $id]);
    }
    
    public function search($query) {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT p.*, c.name as category_name 
                FROM " . $this->table . " p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.name LIKE :query OR p.description LIKE :query 
                OR p.processor LIKE :query OR p.graphics_card LIKE :query";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['query' => '%' . $query . '%']);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>