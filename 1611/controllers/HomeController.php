<?php
require_once 'models/Product.php';
require_once 'models/Category.php';

class HomeController {
    private $productModel;
    private $categoryModel;
    
    public function __construct() {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }
    
    public function index() {
        // Obtener productos destacados
        $featuredProducts = $this->productModel->getFeatured();
        
        // Obtener categorías para el menú si es necesario
        $categories = $this->categoryModel->getAll();
        
        require 'views/home.php';
    }
}
?>