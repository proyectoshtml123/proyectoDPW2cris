<?php require 'views/layouts/header.php'; ?>

<!-- Hero Section -->
<div class="hero-section bg-dark text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold">TecnoStore - Venta de Computadoras</h1>
                <p class="lead">Encuentra las mejores laptops, PCs de escritorio y componentes al mejor precio</p>
                <a href="index.php?controller=product&action=catalog" class="btn btn-primary btn-lg">Ver Catálogo</a>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5" class="img-fluid rounded" alt="Computadoras">
            </div>
        </div>
    </div>
</div>

<!-- Productos Destacados -->
<div class="container">
    <h2 class="text-center mb-4">Productos Destacados</h2>
    <div class="row">
        <?php
        require_once 'models/Product.php';
        $productModel = new Product();
        $featuredProducts = $productModel->getFeatured();
        
        foreach ($featuredProducts as $product): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 product-card">
                <img src="<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                    <p class="card-text"><?php echo substr($product['description'], 0, 100); ?>...</p>
                    <div class="specs">
                        <small class="text-muted">
                            <strong>Procesador:</strong> <?php echo $product['processor']; ?><br>
                            <strong>RAM:</strong> <?php echo $product['ram']; ?><br>
                            <strong>Almacenamiento:</strong> <?php echo $product['storage']; ?>
                        </small>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0 text-primary">$<?php echo number_format($product['price'], 2); ?></span>
                        <div>
                            <a href="index.php?controller=product&action=show&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-primary">Ver Detalles</a>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <form action="index.php?controller=cart&action=add" method="POST" class="d-inline">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-primary">Agregar</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Categorías -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="text-center mb-4">Categorías</h3>
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <div class="category-card p-4 border rounded">
                        <h5>Laptops Gaming</h5>
                        <p class="text-muted">Alto rendimiento para gamers</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="category-card p-4 border rounded">
                        <h5>Laptops Empresariales</h5>
                        <p class="text-muted">Para profesionales</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="category-card p-4 border rounded">
                        <h5>Laptops Estudiantes</h5>
                        <p class="text-muted">Económicas y eficientes</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="category-card p-4 border rounded">
                        <h5>PCs de Escritorio</h5>
                        <p class="text-muted">Máxima potencia</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>