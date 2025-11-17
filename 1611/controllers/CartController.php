<?php
class CartController {
    private $productModel;
    private $orderModel;
    
    public function __construct() {
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }
    
    public function add() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Debe iniciar sesión para agregar productos al carrito';
            header('Location: index.php?action=login');
            exit;
        }
        
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'] ?? 1;
        
        $product = $this->productModel->getById($product_id);
        
        if (!$product) {
            $_SESSION['error'] = 'Producto no encontrado';
            header('Location: index.php?controller=product&action=catalog');
            exit;
        }
        
        // Inicializar carrito si no existe
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Agregar producto al carrito
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image_url' => $product['image_url']
            ];
        }
        
        $_SESSION['success'] = 'Producto agregado al carrito';
        header('Location: index.php?controller=cart&action=view');
        exit;
    }
    
    public function view() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        
        require 'views/cart/view.php';
    }
    
    public function update() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        }
        
        $_SESSION['success'] = 'Carrito actualizado';
        header('Location: index.php?controller=cart&action=view');
        exit;
    }
    
    public function remove($product_id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        
        unset($_SESSION['cart'][$product_id]);
        $_SESSION['success'] = 'Producto eliminado del carrito';
        header('Location: index.php?controller=cart&action=view');
        exit;
    }
    
    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        
        if (empty($_SESSION['cart'])) {
            $_SESSION['error'] = 'El carrito está vacío';
            header('Location: index.php?controller=cart&action=view');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $shipping_address = trim($_POST['shipping_address']);
            $full_name = trim($_POST['full_name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $city = trim($_POST['city']);
            $notes = trim($_POST['notes'] ?? '');
            
            // Construir dirección completa
            $complete_address = "Nombre: $full_name\n";
            $complete_address .= "Email: $email\n";
            $complete_address .= "Teléfono: $phone\n";
            $complete_address .= "Ciudad: $city\n";
            $complete_address .= "Dirección: $shipping_address\n";
            if (!empty($notes)) {
                $complete_address .= "Notas: $notes";
            }
            
            // Preparar items para la orden
            $items = [];
            foreach ($_SESSION['cart'] as $product_id => $item) {
                $items[] = [
                    'product_id' => $product_id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ];
            }
            
            // Crear orden
            $order_id = $this->orderModel->createOrder($_SESSION['user_id'], $items, $complete_address);
            
            if ($order_id) {
                // Limpiar carrito
                unset($_SESSION['cart']);
                $_SESSION['success'] = '¡Pedido realizado exitosamente! Número de orden: #' . $order_id;
                header('Location: index.php');
                exit;
            } else {
                $_SESSION['error'] = 'Error al crear la orden. Por favor, intente nuevamente.';
            }
        }
        
        require 'views/cart/checkout.php';
    }
}
?>