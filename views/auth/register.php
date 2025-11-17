<?php require 'views/layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-plus"></i> Crear Cuenta</h4>
                </div>
                <div class="card-body">
                    <form action="index.php?action=register" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo $_POST['name'] ?? ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo $_POST['email'] ?? ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" 
                                   minlength="6" required>
                            <div class="form-text">Mínimo 6 caracteres</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="confirm_password" 
                                   name="confirm_password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus"></i> Registrarse
                        </button>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <p>¿Ya tienes cuenta? 
                            <a href="index.php?action=login" class="text-decoration-none">
                                Inicia sesión aquí
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>