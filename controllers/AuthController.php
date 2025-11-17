<?php
require_once 'models/User.php';

class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function register() {
        // Si el usuario ya está logueado, redirigir al home
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'role' => 'customer' // Por defecto todos son clientes
            ];
            
            // Validaciones
            $errors = [];
            
            if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
                $errors[] = 'Por favor, complete todos los campos';
            }
            
            if ($data['password'] !== $data['confirm_password']) {
                $errors[] = 'Las contraseñas no coinciden';
            }
            
            if (strlen($data['password']) < 6) {
                $errors[] = 'La contraseña debe tener al menos 6 caracteres';
            }
            
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'El formato del email no es válido';
            }
            
            if ($this->userModel->emailExists($data['email'])) {
                $errors[] = 'El email ya está registrado';
            }
            
            if (empty($errors)) {
                // Remover confirm_password antes de guardar
                unset($data['confirm_password']);
                
                if ($this->userModel->register($data)) {
                    $_SESSION['success'] = 'Registro exitoso. Por favor, inicie sesión.';
                    header('Location: index.php?action=login');
                    exit;
                } else {
                    $errors[] = 'Error en el registro. Por favor, intente nuevamente.';
                }
            }
            
            if (!empty($errors)) {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        require 'views/auth/register.php';
    }
    
    public function login() {
        // Si el usuario ya está logueado, redirigir al home
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            
            // Validaciones básicas
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Por favor, complete todos los campos';
                header('Location: index.php?action=login');
                exit;
            }
            
            $user = $this->userModel->login($email, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                $_SESSION['success'] = '¡Bienvenido ' . $user['name'] . '!';
                
                // Redirigir según el rol
                if ($user['role'] == 'admin') {
                    header('Location: index.php?controller=product&action=index');
                } else {
                    header('Location: index.php');
                }
                exit;
            } else {
                $_SESSION['error'] = 'Credenciales incorrectas';
                header('Location: index.php?action=login');
                exit;
            }
        }
        
        require 'views/auth/login.php';
    }
    
    public function logout() {
        // Destruir todas las variables de sesión
        $_SESSION = array();
        
        // Destruir la sesión
        session_destroy();
        
        // Redirigir al login
        header('Location: index.php');
        exit;
    }
}
?>