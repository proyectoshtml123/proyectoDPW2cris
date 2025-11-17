<?php require 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2><i class="fas fa-credit-card"></i> Finalizar Compra</h2>
    
    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-warning">
            <h4>Carrito vacío</h4>
            <p>No hay productos en tu carrito para proceder al pago.</p>
            <a href="index.php?controller=product&action=catalog" class="btn btn-primary">
                Ver Productos
            </a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Información de Envío</h5>
                    </div>
                    <div class="card-body">
                        <form action="index.php?controller=cart&action=checkout" method="POST">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" 
                                       value="<?php echo $_SESSION['user_name'] ?? ''; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo $_SESSION['user_email'] ?? ''; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Dirección de Envío</label>
                                <textarea class="form-control" id="shipping_address" name="shipping_address" 
                                          rows="4" required placeholder="Calle, número, colonia, ciudad, estado, código postal"></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" id="city" name="city" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="notes" class="form-label">Instrucciones especiales (opcional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" 
                                          placeholder="Instrucciones para la entrega..."></textarea>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check"></i> Confirmar Pedido
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Resumen del Pedido</h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        $total = 0;
                        foreach ($_SESSION['cart'] as $product_id => $item): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <small><?php echo htmlspecialchars($item['name']); ?></small>
                                <br>
                                <small class="text-muted">Cantidad: <?php echo $item['quantity']; ?></small>
                            </div>
                            <small>$<?php echo number_format($subtotal, 2); ?></small>
                        </div>
                        <?php endforeach; ?>
                        
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>$<?php echo number_format($total, 2); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Envío:</span>
                            <span>$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Impuestos (16%):</span>
                            <span>$<?php echo number_format($total * 0.16, 2); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong>$<?php echo number_format($total * 1.16, 2); ?></strong>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-body">
                        <h6>Productos en el carrito:</h6>
                        <ul class="list-unstyled">
                            <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                            <li class="small">
                                <i class="fas fa-laptop text-primary"></i>
                                <?php echo htmlspecialchars($item['name']); ?> 
                                <span class="text-muted">(x<?php echo $item['quantity']; ?>)</span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require 'views/layouts/footer.php'; ?>