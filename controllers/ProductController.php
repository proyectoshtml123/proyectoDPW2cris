<?php
require_once 'models/Product.php';
require_once 'models/Category.php';

class ProductController {
    private $productModel;
    private $categoryModel;
    
    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }
    
    public function index() {
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();
        require 'views/products/index.php';
    }
    
    public function catalog() {
        $category_id = $_GET['category'] ?? null;
        $search = $_GET['search'] ?? null;
        
        if ($search) {
            $products = $this->productModel->search($search);
        } elseif ($category_id) {
            $products = $this->productModel->getByCategory($category_id);
        } else {
            $products = $this->productModel->getAll();
        }
        
        $categories = $this->categoryModel->getAll();
        require 'views/products/catalog.php';
    }
    
    public function show($id) {
        $product = $this->productModel->getById($id);
        if (!$product) {
            $_SESSION['error'] = 'Producto no encontrado';
            header('Location: index.php?controller=product&action=catalog');
            exit;
        }
        require 'views/products/show.php';
    }
    
    public function create() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $_SESSION['error'] = 'Acceso denegado';
            header('Location: index.php');
            exit;
        }
        
        $categories = $this->categoryModel->getAll();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'price' => trim($_POST['price']),
                'stock' => trim($_POST['stock']),
                'category_id' => trim($_POST['category_id']),
                'processor' => trim($_POST['processor']),
                'ram' => trim($_POST['ram']),
                'storage' => trim($_POST['storage']),
                'graphics_card' => trim($_POST['graphics_card']),
                'screen_size' => trim($_POST['screen_size']),
                'amazon_link' => trim($_POST['amazon_link']),
                'image_url' => trim($_POST['image_url']),
                'featured' => isset($_POST['featured']) ? 1 : 0
            ];
            
            if ($this->productModel->create($data)) {
                $_SESSION['success'] = 'Producto creado exitosamente';
                header('Location: index.php?controller=product&action=index');
                exit;
            } else {
                $_SESSION['error'] = 'Error al crear el producto';
            }
        }
        
        require 'views/products/create.php';
    }
    
    public function edit($id) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $_SESSION['error'] = 'Acceso denegado';
            header('Location: index.php');
            exit;
        }
        
        $product = $this->productModel->getById($id);
        $categories = $this->categoryModel->getAll();
        
        if (!$product) {
            $_SESSION['error'] = 'Producto no encontrado';
            header('Location: index.php?controller=product&action=index');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'price' => trim($_POST['price']),
                'stock' => trim($_POST['stock']),
                'category_id' => trim($_POST['category_id']),
                'processor' => trim($_POST['processor']),
                'ram' => trim($_POST['ram']),
                'storage' => trim($_POST['storage']),
                'graphics_card' => trim($_POST['graphics_card']),
                'screen_size' => trim($_POST['screen_size']),
                'amazon_link' => trim($_POST['amazon_link']),
                'image_url' => trim($_POST['image_url']),
                'featured' => isset($_POST['featured']) ? 1 : 0
            ];
            
            if ($this->productModel->update($id, $data)) {
                $_SESSION['success'] = 'Producto actualizado exitosamente';
                header('Location: index.php?controller=product&action=index');
                exit;
            } else {
                $_SESSION['error'] = 'Error al actualizar el producto';
            }
        }
        
        require 'views/products/edit.php';
    }
    
    public function delete($id) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
            $_SESSION['error'] = 'Acceso denegado';
            header('Location: index.php');
            exit;
        }
        
        if ($this->productModel->delete($id)) {
            $_SESSION['success'] = 'Producto eliminado exitosamente';
        } else {
            $_SESSION['error'] = 'Error al eliminar el producto';
        }
        
        header('Location: index.php?controller=product&action=index');
        exit;
    }
}
?>