<?php
class Order {
    private $db;
    private $table = 'orders';
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function createOrder($user_id, $items, $shipping_address) {
        $conn = $this->db->getConnection();
        
        try {
            $conn->beginTransaction();
            
            // Calcular total
            $total = 0;
            foreach ($items as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            // Crear orden
            $sql = "INSERT INTO " . $this->table . " (user_id, total, shipping_address) VALUES (:user_id, :total, :shipping_address)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'user_id' => $user_id,
                'total' => $total,
                'shipping_address' => $shipping_address
            ]);
            
            $order_id = $conn->lastInsertId();
            
            // Crear items de la orden
            foreach ($items as $item) {
                $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'order_id' => $order_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }
            
            $conn->commit();
            return $order_id;
            
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }
    
    public function getUserOrders($user_id) {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT o.*, COUNT(oi.id) as items_count 
                FROM " . $this->table . " o 
                LEFT JOIN order_items oi ON o.id = oi.order_id 
                WHERE o.user_id = :user_id 
                GROUP BY o.id 
                ORDER BY o.created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getOrderDetails($order_id) {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT o.*, oi.quantity, oi.price, p.name as product_name 
                FROM " . $this->table . " o 
                JOIN order_items oi ON o.id = oi.order_id 
                JOIN products p ON oi.product_id = p.id 
                WHERE o.id = :order_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['order_id' => $order_id]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>