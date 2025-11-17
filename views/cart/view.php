<?php require 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2><i class="fas fa-shopping-cart"></i> Mi Carrito</h2>
    
    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info">
            <h4>Tu carrito está vacío</h4>
            <p>¡Descubre nuestros productos y encuentra la computadora perfecta para ti!</p>
            <a href="index.php?controller=product&action=catalog" class="btn btn-primary">
                <i class="fas fa-laptop"></i> Ver Catálogo
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Productos en el Carrito</h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $product_id => $item): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                        <div class="cart-item border-bottom pb-3 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="<?php echo $item['image_url']; ?>" 
                                         class="img-fluid rounded" 
                                         alt="<?php echo $item['name']; ?>"
                                         style="height: 80px; object-fit: cover;">
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1"><?php echo htmlspecialchars($item['name']); ?></h6>
                                    <p class="text-muted mb-0">$<?php echo number_format($item['price'], 2); ?></p>
                                </div>
                                <div class="col-md-3">
                                    <form action="index.php?controller=cart&action=update" method="POST" class="d-flex align-items-center">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <input type="number" 
                                               name="quantity" 
                                               value="<?php echo $item['quantity']; ?>" 
                                               min="1" 
                                               max="10"
                                               class="form-control form-control-sm"
                                               style="width: 80px;">
                                        <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-2">
                                    <strong>$<?php echo number_format($subtotal, 2); ?></strong>
                                </div>
                                <div class="col-md-1">
                                    <a href="index.php?controller=cart&action=remove&id=<?php echo $product_id; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Eliminar producto del carrito?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Resumen del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>$<?php echo number_format($total, 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Envío:</span>
                            <span>$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Impuestos:</span>
                            <span>$<?php echo number_format($total * 0.16, 2); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong>$<?php echo number_format($total * 1.16, 2); ?></strong>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="index.php?controller=cart&action=checkout" 
                               class="btn btn-primary btn-lg">
                                <i class="fas fa-credit-card"></i> Proceder al Pago
                            </a>
                            <a href="index.php?controller=product&action=catalog" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-shopping-bag"></i> Seguir Comprando
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require 'views/layouts/footer.php'; ?>