<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid order-page">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="bi bi-plus-circle-fill me-2 text-primary"></i>
                    Place New Order
                </h2>
                <div class="order-summary-badge">
                    <span class="badge bg-info fs-6 px-3 py-2">
                        <i class="bi bi-cart3 me-1"></i>
                        Items in Cart: <span id="cart-count">0</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <form action="/orders/create" method="post" id="order-form">
        <?= csrf_field() ?>
        
        <div class="row g-4">
            <!-- Order Details Sidebar -->
            <div class="col-lg-3 col-md-4">
                <div class="card shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-clipboard-check me-2"></i>
                            Order Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="table_id" class="form-label fw-bold">Select Table</label>
                            <select name="table_id" class="form-select form-select-lg" required>
                                <option value="">-- Choose Table --</option>
                                <?php foreach($tables as $table): ?>
                                    <option value="<?= $table['id'] ?>"><?= esc($table['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="order-summary mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold">Total Amount:</span>
                                <span class="fs-5 fw-bold text-success" id="sidebar-total">₹0.00</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">
                            <i class="bi bi-check-circle me-2"></i>
                            Place Order
                        </button>
                        
                        <div class="mt-3 text-center">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Review your order below before placing
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Section -->
            <div class="col-lg-9 col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                <h4 class="mb-0 me-3">
                                    <i class="bi bi-menu-button-wide me-2 text-primary"></i>
                                    Our Menu
                                </h4>
                                <span class="badge bg-primary"><?= count($menu_items) ?> items</span>
                            </div>
                            
                            <!-- View Toggle Buttons -->
                            <div class="btn-group" role="group" aria-label="View toggle">
                                <button type="button" class="btn btn-outline-primary active" id="grid-view-btn">
                                    <i class="bi bi-grid-3x3-gap"></i> Grid
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="table-view-btn">
                                    <i class="bi bi-table"></i> Table
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Category-based Menu Display -->
                        <div id="menu-container">
                            <?php if (!empty($categories)): ?>
                                <?php foreach($categories as $category): ?>
                                    <?php if (isset($menu_by_category[$category['id']]) && !empty($menu_by_category[$category['id']])): ?>
                                        <div class="category-section mb-4">
                                            <div class="category-header d-flex align-items-center justify-content-between p-3 bg-light rounded cursor-pointer" 
                                                 data-bs-toggle="collapse" 
                                                 data-bs-target="#category-<?= $category['id'] ?>" 
                                                 aria-expanded="false">
                                                <h5 class="mb-0 fw-bold text-primary">
                                                    <i class="bi bi-chevron-right category-chevron me-2"></i>
                                                    <?= esc($category['name']) ?>
                                                </h5>
                                                <span class="badge bg-secondary">
                                                    <?= count($menu_by_category[$category['id']]) ?> items
                                                </span>
                                            </div>
                                            
                                            <div class="collapse" id="category-<?= $category['id'] ?>">
                                                <!-- Grid View -->
                                                <div class="grid-view mt-3">
                                                    <div class="row g-3">
                                                        <?php foreach($menu_by_category[$category['id']] as $item): ?>
                                                            <div class="col-xl-4 col-lg-6 col-md-12">
                                                                <div class="card menu-item-card h-100 shadow-sm">
                                                                    <div class="position-relative">
                                                                        <img src="/uploads/<?= $item['image'] ?>" 
                                                                             class="card-img-top" 
                                                                             style="height: 200px; object-fit: cover;"
                                                                             alt="<?= esc($item['name']) ?>">
                                                                        <div class="position-absolute top-0 end-0 m-2">
                                                                            <span class="badge bg-success fs-6">₹<?= number_format($item['price'], 2) ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-body d-flex flex-column">
                                                                        <h6 class="card-title fw-bold"><?= esc($item['name']) ?></h6>
                                                                        <p class="card-text text-muted small flex-grow-1">
                                                                            <?= isset($item['description']) ? esc($item['description']) : 'Delicious and freshly prepared' ?>
                                                                        </p>
                                                                        <div class="mt-auto">
                                                                            <button type="button" 
                                                                                    class="btn btn-primary w-100 add-item-btn shadow-sm" 
                                                                                    data-id="<?= $item['id'] ?>" 
                                                                                    data-name="<?= esc($item['name']) ?>"
                                                                                    data-price="<?= $item['price'] ?>">
                                                                                <i class="bi bi-plus-circle me-2"></i>Add to Order
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                
                                                <!-- Table View -->
                                                <div class="table-view mt-3" style="display: none;">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Image</th>
                                                                    <th>Item Name</th>
                                                                    <th>Price</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($menu_by_category[$category['id']] as $item): ?>
                                                                    <tr>
                                                                        <td>
                                                                            <img src="/uploads/<?= $item['image'] ?>" 
                                                                                 class="rounded" 
                                                                                 style="width: 60px; height: 60px; object-fit: cover;"
                                                                                 alt="<?= esc($item['name']) ?>">
                                                                        </td>
                                                                        <td>
                                                                            <div>
                                                                                <strong><?= esc($item['name']) ?></strong>
                                                                                <br>
                                                                                <small class="text-muted">
                                                                                    <?= isset($item['description']) ? esc($item['description']) : 'Delicious and freshly prepared' ?>
                                                                                </small>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge bg-success fs-6">₹<?= number_format($item['price'], 2) ?></span>
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" 
                                                                                    class="btn btn-primary add-item-btn" 
                                                                                    data-id="<?= $item['id'] ?>" 
                                                                                    data-name="<?= esc($item['name']) ?>"
                                                                                    data-price="<?= $item['price'] ?>">
                                                                                <i class="bi bi-plus-circle me-2"></i>Add
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Order Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-cart-check me-2"></i>
                            Current Order
                            <span class="badge bg-light text-success ms-2" id="order-items-count">0 items</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="order-items">
                                    <tr id="empty-cart-message">
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="bi bi-cart-x" style="font-size: 2rem;"></i>
                                            <br>
                                            <span>Your cart is empty. Add items from the menu above.</span>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                     <tr>
                                        <th colspan="3" class="text-end">Subtotal:</th>
                                        <th id="sub-total">₹0.00</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">GST (5%):</th>
                                        <th id="gst-total">₹0.00</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end fs-5">Grand Total:</th>
                                        <th class="fs-5" id="grand-total">₹0.00</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <input type="hidden" name="grand_total" id="grand-total-input" value="0">
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const orderItemsTbody = document.getElementById('order-items');
    const grandTotalTh = document.getElementById('grand-total');
    const subTotalTh = document.getElementById('sub-total');
    const gstTotalTh = document.getElementById('gst-total');
    const grandTotalInput = document.getElementById('grand-total-input');
    const sidebarTotal = document.getElementById('sidebar-total');
    const cartCount = document.getElementById('cart-count');
    const orderItemsCount = document.getElementById('order-items-count');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    
    // View toggle and other UI scripts remain the same...
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-item-btn') || e.target.closest('.add-item-btn')) {
            const button = e.target.classList.contains('add-item-btn') ? e.target : e.target.closest('.add-item-btn');
            const id = button.dataset.id;
            const name = button.dataset.name;
            const price = parseFloat(button.dataset.price);

            const existingRow = document.querySelector(`#order-items tr[data-id='${id}']`);
            if (existingRow) {
                const quantityInput = existingRow.querySelector('.quantity-input');
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateRowSubtotal(existingRow);
            } else {
                if (emptyCartMessage) emptyCartMessage.style.display = 'none';
                
                const newRow = document.createElement('tr');
                newRow.dataset.id = id;
                newRow.innerHTML = `
                    <td><strong>${name}</strong><input type="hidden" name="items[]" value="${id}"></td>
                    <td>
                        <input type="number" name="quantities[]" class="form-control quantity-input" value="1" min="1" style="width: 80px;">
                    </td>
                    <td class="price">₹${price.toFixed(2)}</td>
                    <td class="subtotal fw-bold text-success">₹${price.toFixed(2)}</td>
                    <input type="hidden" name="subtotals[]" class="subtotal-input" value="${price.toFixed(2)}">
                    <td><button type="button" class="btn btn-danger btn-sm remove-item-btn"><i class="bi bi-trash"></i></button></td>
                `;
                orderItemsTbody.appendChild(newRow);
            }
            updateGrandTotal();
        }
    });
    
    orderItemsTbody.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            const row = e.target.closest('tr');
            if(parseInt(e.target.value) < 1) e.target.value = 1;
            updateRowSubtotal(row);
            updateGrandTotal();
        }
    });

    orderItemsTbody.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item-btn')) {
            e.target.closest('tr').remove();
            updateGrandTotal();
            if (orderItemsTbody.querySelectorAll('tr[data-id]').length === 0 && emptyCartMessage) {
                emptyCartMessage.style.display = 'table-row';
            }
        }
    });

    function updateRowSubtotal(row) {
        const price = parseFloat(row.querySelector('.price').textContent.replace('₹', ''));
        const quantity = parseInt(row.querySelector('.quantity-input').value);
        const subtotal = price * quantity;
        row.querySelector('.subtotal').textContent = '₹' + subtotal.toFixed(2);
        row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
    }

    function updateGrandTotal() {
        let subTotal = 0;
        let itemCount = 0;
        
        document.querySelectorAll('#order-items tr[data-id]').forEach(row => {
            subTotal += parseFloat(row.querySelector('.subtotal-input').value);
            itemCount += parseInt(row.querySelector('.quantity-input').value);
        });
        
        const gst = subTotal * 0.05;
        const grandTotal = subTotal + gst;

        subTotalTh.textContent = '₹' + subTotal.toFixed(2);
        gstTotalTh.textContent = '₹' + gst.toFixed(2);
        grandTotalTh.textContent = '₹' + grandTotal.toFixed(2);
        sidebarTotal.textContent = '₹' + grandTotal.toFixed(2);
        grandTotalInput.value = grandTotal.toFixed(2);
        
        cartCount.textContent = itemCount;
        orderItemsCount.textContent = itemCount + ' items';
    }
});
</script>
<?= $this->endSection() ?>
