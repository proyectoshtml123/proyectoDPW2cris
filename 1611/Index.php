<?php
session_start();

// Cargar configuración PRIMERO
require_once 'config/database.php';

// Función para cargar clases automáticamente
spl_autoload_register(function ($class) {
    // Directorios donde buscar las clases
    $directories = [
        'controllers/',
        'models/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    
    return false;
});

// Obtener parámetros de la URL
$controller = $_GET['controller'] ?? '';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? 0;

// Routing principal
try {
    switch ($controller) {
        case 'product':
            $productController = new ProductController();
            switch ($action) {
                case 'index': $productController->index(); break;
                case 'catalog': $productController->catalog(); break;
                case 'show': $productController->show($id); break;
                case 'create': $productController->create(); break;
                case 'edit': $productController->edit($id); break;
                case 'delete': $productController->delete($id); break;
                default: $productController->catalog();
            }
            break;
            
        case 'cart':
            $cartController = new CartController();
            switch ($action) {
                case 'add': $cartController->add(); break;
                case 'view': $cartController->view(); break;
                case 'update': $cartController->update(); break;
                case 'remove': $cartController->remove($id); break;
                case 'checkout': $cartController->checkout(); break;
                default: $cartController->view();
            }
            break;
            
        default:
            switch ($action) {
                case 'register':
                    $authController = new AuthController();
                    $authController->register();
                    break;
                case 'login':
                    $authController = new AuthController();
                    $authController->login();
                    break;
                case 'logout':
                    $authController = new AuthController();
                    $authController->logout();
                    break;
                default:
                    $homeController = new HomeController();
                    $homeController->index();
            }
    }
} catch (Exception $e) {
    // Manejo de errores
    echo "<div class='alert alert-danger m-3'>
            <h4>Error</h4>
            <p>" . $e->getMessage() . "</p>
            <small>Archivo: " . $e->getFile() . " - Línea: " . $e->getLine() . "</small>
          </div>";
}
?>