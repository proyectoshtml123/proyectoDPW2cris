<?php
class User {
    private $db;
    private $table = 'users';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function register($data) {
        $conn = $this->db->getConnection();
        
        $sql = "INSERT INTO " . $this->table . " (name, email, password, role) VALUES (:name, :email, :password, :role)";
        
        $stmt = $conn->prepare($sql);
        
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        return $stmt->execute($data);
    }
    
    public function login($email, $password) {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function getUserById($id) {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function emailExists($email) {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT id FROM " . $this->table . " WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        return $stmt->rowCount() > 0;
    }
    
    public function updateProfile($id, $data) {
        $conn = $this->db->getConnection();
        
        $sql = "UPDATE " . $this->table . " SET name = :name, email = :email WHERE id = :id";
        $stmt = $conn->prepare($sql);
        
        $data['id'] = $id;
        return $stmt->execute($data);
    }
    
    public function getAllUsers() {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT id, name, email, role, created_at FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>