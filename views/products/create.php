<?php require 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-plus"></i> Agregar Nuevo Producto</h4>
                </div>
                <div class="card-body">
                    <form action="index.php?controller=product&action=create" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Precio</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Categoría</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Seleccionar categoría</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="processor" class="form-label">Procesador</label>
                                <input type="text" class="form-control" id="processor" name="processor" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ram" class="form-label">Memoria RAM</label>
                                <input type="text" class="form-control" id="ram" name="ram" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="storage" class="form-label">Almacenamiento</label>
                                <input type="text" class="form-control" id="storage" name="storage" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="graphics_card" class="form-label">Tarjeta Gráfica</label>
                                <input type="text" class="form-control" id="graphics_card" name="graphics_card" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="screen_size" class="form-label">Tamaño de Pantalla</label>
                                <input type="text" class="form-control" id="screen_size" name="screen_size">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="image_url" class="form-label">URL de Imagen</label>
                                <input type="url" class="form-control" id="image_url" name="image_url" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="amazon_link" class="form-label">Enlace de Amazon (opcional)</label>
                            <input type="url" class="form-control" id="amazon_link" name="amazon_link">
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="featured" name="featured" value="1">
                            <label class="form-check-label" for="featured">Producto Destacado</label>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php?controller=product&action=index" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>