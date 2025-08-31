<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid order-page">
    <!-- Error/Success Messages -->
    <?php if(session()->get('error')): ?>
        <div class="alert alert-danger"><?= session()->get('error') ?></div>
    <?php endif; ?>
    <?php if(session()->get('status')): ?>
        <div class="alert alert-success"><?= session()->get('status') ?></div>
    <?php endif; ?>

    <form action="/cashier/orders/create" method="post" id="order-form">
        <?= csrf_field() ?>
        
        <div class="row g-4">
            <!-- Order Details Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-clipboard-check me-2"></i>Order Details</h5>
                    </div>
                    <div class="card-body">
                        <!-- Order Type Selection -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Order Type</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="order_type" id="dine_in" value="dine_in" autocomplete="off" checked>
                                <label class="btn btn-outline-primary" for="dine_in">Dine-In</label>

                                <input type="radio" class="btn-check" name="order_type" id="take_away" value="take_away" autocomplete="off">
                                <label class="btn btn-outline-primary" for="take_away">Take Away</label>
                            </div>
                        </div>

                        <!-- Table Selection (for Dine-In) -->
                        <div class="mb-3" id="table-selection">
                            <label for="table_id" class="form-label fw-bold">Select Table</label>
                            <select name="table_id" id="table_id" class="form-select form-select-lg" required>
                                <option value="">-- Choose Table --</option>
                                <?php foreach($tables as $table): ?>
                                    <option value="<?= $table['id'] ?>"><?= esc($table['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Order Summary -->
                        <div class="order-summary mb-3">
                            <div id="order-items-summary" class="list-group mb-3">
                                <!-- Order items will be dynamically added here -->
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fs-5 fw-bold">Total:</span>
                                <span class="fs-4 fw-bold text-success" id="sidebar-total">₹0.00</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">
                            <i class="bi bi-cash-coin me-2"></i>Complete Payment & Place Order
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menu Section -->
            <div class="col-lg-8">
                 <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h4 class="mb-0"><i class="bi bi-menu-button-wide me-2 text-primary"></i>Menu</h4>
                    </div>
                    <div class="card-body">
                         <?php foreach($categories as $category): ?>
                             <?php if (isset($menu_by_category[$category['id']]) && !empty($menu_by_category[$category['id']])): ?>
                                <h5 class="mt-4"><?= esc($category['name']) ?></h5>
                                <div class="row g-3">
                                    <?php foreach($menu_by_category[$category['id']] as $item): ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card menu-item-card h-100 shadow-sm text-center add-item-btn" 
                                                 data-id="<?= $item['id'] ?>" 
                                                 data-name="<?= esc($item['name']) ?>"
                                                 data-price="<?= $item['price'] ?>"
                                                 style="cursor:pointer;">
                                                <img src="/uploads/<?= $item['image'] ?>" class="card-img-top" style="height: 150px; object-fit: cover;" alt="<?= esc($item['name']) ?>">
                                                <div class="card-body">
                                                    <h6 class="card-title fw-bold"><?= esc($item['name']) ?></h6>
                                                    <p class="card-text text-success fw-bold">₹<?= number_format($item['price'], 2) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                 </div>
            </div>
        </div>
        
        <!-- Hidden inputs for form submission -->
        <div id="hidden-inputs"></div>
        <input type="hidden" name="grand_total" id="grand-total-input" value="0">
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const orderItemsSummary = document.getElementById('order-items-summary');
    const sidebarTotal = document.getElementById('sidebar-total');
    const grandTotalInput = document.getElementById('grand-total-input');
    const hiddenInputsContainer = document.getElementById('hidden-inputs');

    const order = {};

    // Handle clicking on menu items
    document.querySelectorAll('.add-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);

            if (order[id]) {
                order[id].quantity++;
            } else {
                order[id] = { name, price, quantity: 1 };
            }
            updateOrderSummary();
        });
    });

    // Handle order type change
    document.querySelectorAll('input[name="order_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const tableSelection = document.getElementById('table-selection');
            const tableIdInput = document.getElementById('table_id');
            if (this.value === 'dine_in') {
                tableSelection.style.display = 'block';
                tableIdInput.required = true;
            } else {
                tableSelection.style.display = 'none';
                tableIdInput.required = false;
            }
        });
    });

    function updateOrderSummary() {
        orderItemsSummary.innerHTML = '';
        hiddenInputsContainer.innerHTML = '';
        let grandTotal = 0;

        if (Object.keys(order).length === 0) {
            orderItemsSummary.innerHTML = '<p class="text-center text-muted">No items in order.</p>';
        }

        for (const id in order) {
            const item = order[id];
            const subtotal = item.price * item.quantity;
            grandTotal += subtotal;

            const itemElement = document.createElement('div');
            itemElement.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
            itemElement.innerHTML = `
                <div>
                    <strong class="item-name">${item.name}</strong>
                    <br>
                    <small>₹${item.price.toFixed(2)}</small>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-secondary decrease-qty" data-id="${id}">-</button>
                    <span class="mx-2 quantity">${item.quantity}</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary increase-qty" data-id="${id}">+</button>
                </div>
                <strong class="subtotal">₹${subtotal.toFixed(2)}</strong>
            `;
            orderItemsSummary.appendChild(itemElement);

            // Add hidden inputs for form submission
            hiddenInputsContainer.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="items[]" value="${id}">
                <input type="hidden" name="quantities[]" value="${item.quantity}">
                <input type="hidden" name="subtotals[]" value="${subtotal.toFixed(2)}">
            `);
        }

        sidebarTotal.textContent = '₹' + grandTotal.toFixed(2);
        grandTotalInput.value = grandTotal.toFixed(2);
    }

    orderItemsSummary.addEventListener('click', function(e) {
        if (e.target.classList.contains('increase-qty')) {
            const id = e.target.dataset.id;
            order[id].quantity++;
        }
        if (e.target.classList.contains('decrease-qty')) {
            const id = e.target.dataset.id;
            if (order[id].quantity > 1) {
                order[id].quantity--;
            } else {
                delete order[id];
            }
        }
        updateOrderSummary();
    });
    
    // Form validation
    document.getElementById('order-form').addEventListener('submit', function(e) {
        if (Object.keys(order).length === 0) {
            e.preventDefault();
            alert('Please add at least one item to the order.');
        }
    });

});
</script>
<?= $this->endSection() ?>
