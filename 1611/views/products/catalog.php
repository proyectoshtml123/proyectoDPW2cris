<?php require 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar de Categorías -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>Categorías</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="index.php?controller=product&action=catalog" 
                           class="list-group-item list-group-item-action <?php echo !isset($_GET['category']) ? 'active' : ''; ?>">
                            Todas las Categorías
                        </a>
                        <?php foreach ($categories as $category): ?>
                        <a href="index.php?controller=product&action=catalog&category=<?php echo $category['id']; ?>" 
                           class="list-group-item list-group-item-action <?php echo (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'active' : ''; ?>">
                            <?php echo $category['name']; ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Lista de Productos -->
        <div class="col-md-9">
            <!-- Barra de Búsqueda -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="index.php?controller=product&action=catalog" method="GET">
                        <input type="hidden" name="controller" value="product">
                        <input type="hidden" name="action" value="catalog">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar productos..." value="<?php echo $_GET['search'] ?? ''; ?>">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Productos -->
            <div class="row">
                <?php if (empty($products)): ?>
                <div class="col-12">
                    <div class="alert alert-info">No se encontraron productos.</div>
                </div>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 product-card">
                            <img src="<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?php echo substr($product['description'], 0, 100); ?>...</p>
                                <div class="specs mb-2">
                                    <small class="text-muted">
                                        <strong>Procesador:</strong> <?php echo $product['processor']; ?><br>
                                        <strong>RAM:</strong> <?php echo $product['ram']; ?><br>
                                        <strong>Almacenamiento:</strong> <?php echo $product['storage']; ?>
                                    </small>
                                </div>
                                <?php if (!empty($product['amazon_link'])): ?>
                                <div class="mb-2">
                                    <a href="<?php echo $product['amazon_link']; ?>" target="_blank" class="btn btn-warning btn-sm">
                                        <i class="fas fa-shopping-cart"></i> Ver en Amazon
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0 text-primary">$<?php echo number_format($product['price'], 2); ?></span>
                                    <div>
                                        <a href="index.php?controller=product&action=show&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-primary">Detalles</a>
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
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require 'views/layouts/footer.php'; ?>