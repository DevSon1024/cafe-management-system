<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid order-page">
    <?php if(session()->get('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->get('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="bi bi-plus-circle-fill me-2 text-primary"></i>
                    Place Your Order
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

    <form action="/order/create" method="post" id="order-form">
        <?= csrf_field() ?>

        <div class="row g-4">
            <div class="col-lg-3 col-md-4">
                <div class="card shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-clipboard-check me-2"></i>
                            Order Details
                        </h5>
                    </div>
                    <div class="card-body">
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
                                                <div class="grid-view mt-3">
                                                    <div class="row g-3">
                                                        <?php foreach($menu_by_category[$category['id']] as $item): ?>
                                                            <div class="col-xl-4 col-lg-6 col-md-12">
                                                                <div class="card menu-item-card h-100 shadow-sm">
                                                                    <img src="/uploads/<?= $item['image'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= esc($item['name']) ?>">
                                                                    <div class="card-body d-flex flex-column">
                                                                        <h6 class="card-title fw-bold"><?= esc($item['name']) ?></h6>
                                                                        <p class="card-text text-muted small flex-grow-1">
                                                                            <?= isset($item['description']) ? esc($item['description']) : 'Delicious and freshly prepared' ?>
                                                                        </p>
                                                                        <p class="card-text fw-bold text-primary">₹<?= number_format($item['price'], 2) ?></p>
                                                                        <div class="mt-auto">
                                                                            <button type="button" class="btn btn-primary w-100 add-item-btn shadow-sm" data-id="<?= $item['id'] ?>" data-name="<?= esc($item['name']) ?>" data-price="<?= $item['price'] ?>">
                                                                                <i class="bi bi-plus-circle me-2"></i>Add to Order
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>

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
                                                                            <img src="/uploads/<?= $item['image'] ?>" class="rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="<?= esc($item['name']) ?>">
                                                                        </td>
                                                                        <td><?= esc($item['name']) ?></td>
                                                                        <td>₹<?= number_format($item['price'], 2) ?></td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-primary add-item-btn" data-id="<?= $item['id'] ?>" data-name="<?= esc($item['name']) ?>" data-price="<?= $item['price'] ?>">
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

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-cart-check me-2"></i>
                            Your Order
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
                                            Your cart is empty.
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
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
    const grandTotalInput = document.getElementById('grand-total-input');
    const sidebarTotal = document.getElementById('sidebar-total');
    const cartCount = document.getElementById('cart-count');
    const emptyCartMessage = document.getElementById('empty-cart-message');
    const gridViewBtn = document.getElementById('grid-view-btn');
    const tableViewBtn = document.getElementById('table-view-btn');
    
    gridViewBtn.addEventListener('click', function() {
        document.querySelectorAll('.grid-view').forEach(el => el.style.display = 'block');
        document.querySelectorAll('.table-view').forEach(el => el.style.display = 'none');
        gridViewBtn.classList.add('active');
        tableViewBtn.classList.remove('active');
    });
    
    tableViewBtn.addEventListener('click', function() {
        document.querySelectorAll('.grid-view').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.table-view').forEach(el => el.style.display = 'block');
        tableViewBtn.classList.add('active');
        gridViewBtn.classList.remove('active');
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.category-header')) {
            const header = e.target.closest('.category-header');
            const chevron = header.querySelector('.category-chevron');
            const target = header.getAttribute('data-bs-target');
            const collapse = document.querySelector(target);
            
            setTimeout(() => {
                if (collapse.classList.contains('show')) {
                    chevron.style.transform = 'rotate(90deg)';
                } else {
                    chevron.style.transform = 'rotate(0deg)';
                }
            }, 10);
        }
    });

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
                if (emptyCartMessage) {
                    emptyCartMessage.style.display = 'none';
                }
                
                const newRow = document.createElement('tr');
                newRow.dataset.id = id;
                newRow.innerHTML = `
                    <td>
                        <strong>${name}</strong>
                        <input type="hidden" name="items[]" value="${id}">
                    </td>
                    <td>
                        <input type="number" name="quantities[]" class="form-control quantity-input" value="1" min="1" style="width: 70px;">
                    </td>
                    <td class="price">₹${price.toFixed(2)}</td>
                    <td class="subtotal">₹${price.toFixed(2)}</td>
                    <input type="hidden" name="subtotals[]" class="subtotal-input" value="${price.toFixed(2)}">
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item-btn">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                orderItemsTbody.appendChild(newRow);
            }
            updateGrandTotal();
        }
    });
    
    orderItemsTbody.addEventListener('change', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            const row = e.target.closest('tr');
            updateRowSubtotal(row);
            updateGrandTotal();
        }
    });

    orderItemsTbody.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item-btn') || e.target.closest('.remove-item-btn')) {
            const row = e.target.closest('tr');
            row.remove();
            updateGrandTotal();
            
            const remainingItems = orderItemsTbody.querySelectorAll('tr[data-id]');
            if (remainingItems.length === 0 && emptyCartMessage) {
                emptyCartMessage.style.display = 'table-row';
            }
        }
    });

    function updateRowSubtotal(row) {
        const priceText = row.querySelector('.price').textContent.replace('₹', '');
        const price = parseFloat(priceText);
        const quantity = parseInt(row.querySelector('.quantity-input').value);
        const subtotal = price * quantity;
        row.querySelector('.subtotal').textContent = '₹' + subtotal.toFixed(2);
        row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
    }

    function updateGrandTotal() {
        let total = 0;
        let itemCount = 0;
        
        document.querySelectorAll('#order-items tr[data-id]').forEach(row => {
            const subtotalText = row.querySelector('.subtotal').textContent.replace('₹', '');
            const quantity = parseInt(row.querySelector('.quantity-input').value);
            total += parseFloat(subtotalText);
            itemCount += quantity;
        });
        
        const formattedTotal = '₹' + total.toFixed(2);
        grandTotalTh.textContent = formattedTotal;
        grandTotalInput.value = total.toFixed(2);
        sidebarTotal.textContent = formattedTotal;
        cartCount.textContent = itemCount;
    }
});
</script>
<?= $this->endSection() ?>