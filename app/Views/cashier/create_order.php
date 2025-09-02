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
                    New Order
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

    <form action="/cashier/orders/create" method="post" id="order-form">
        <?= csrf_field() ?>

        <div class="row g-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                         <div class="row align-items-center">
                            <div class="col-md-4">
                               <h4 class="mb-0">
                                    <i class="bi bi-menu-button-wide me-2 text-primary"></i>
                                    Our Menu
                                </h4>
                            </div>
                             <div class="col-md-8 d-flex justify-content-end align-items-center gap-3">
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="order_type" id="dine_in" value="dine_in" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary" for="dine_in"><i class="bi bi-cup-straw me-2"></i>Dine-In</label>

                                    <input type="radio" class="btn-check" name="order_type" id="take_away" value="take_away" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="take_away"><i class="bi bi-bag-check-fill me-2"></i>Take Away</label>
                                </div>
                                <div id="table-selection">
                                    <select name="table_id" id="table_id" class="form-select" required>
                                        <option value="">-- Choose Table --</option>
                                        <?php foreach($tables as $table): ?>
                                            <option value="<?= $table['id'] ?>"><?= esc($table['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                         <?php foreach($categories as $category): ?>
                            <?php if (isset($menu_by_category[$category['id']]) && !empty($menu_by_category[$category['id']])): ?>
                                <h5 class="mt-3"><?= esc($category['name']) ?></h5>
                                <div class="row g-3">
                                    <?php foreach($menu_by_category[$category['id']] as $item): ?>
                                    <div class="col-md-4">
                                        <div class="card menu-item-card h-100 shadow-sm">
                                            <img src="/uploads/<?= $item['image'] ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="<?= esc($item['name']) ?>">
                                            <div class="card-body d-flex flex-column">
                                                <h6 class="card-title fw-bold"><?= esc($item['name']) ?></h6>
                                                <p class="card-text text-primary fw-bold">₹<?= number_format($item['price'], 2) ?></p>
                                                <div class="mt-auto">
                                                    <button type="button" class="btn btn-primary w-100 add-item-btn" data-id="<?= $item['id'] ?>" data-name="<?= esc($item['name']) ?>" data-price="<?= $item['price'] ?>">
                                                        <i class="bi bi-plus-circle me-2"></i>Add
                                                    </button>
                                                </div>
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

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="bi bi-cart-check me-2"></i>Your Order</h4>
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
                                    <tr id="empty-cart-message"><td colspan="5" class="text-center py-4 text-muted">Your cart is empty.</td></tr>
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
         <button type="submit" id="main-submit-btn" class="d-none">Submit</button>
    </form>
</div>

<div class="bottom-order-bar hidden" id="bottom-bar">
    <div class="bottom-order-bar-summary">
        <div class="item-count">
            <i class="bi bi-cart3"></i>
            <span id="bottom-bar-cart-count">0</span> Items
        </div>
        <div class="total-amount" id="bottom-bar-total">₹0.00</div>
    </div>
    <button type="button" id="bottom-bar-submit-btn" class="btn btn-success btn-lg shadow-sm">
        <i class="bi bi-cash-coin me-2"></i>Complete Payment & Place Order
    </button>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const orderItemsTbody = document.getElementById('order-items');
    const grandTotalTh = document.getElementById('grand-total');
    const subTotalTh = document.getElementById('sub-total');
    const gstTotalTh = document.getElementById('gst-total');
    const grandTotalInput = document.getElementById('grand-total-input');
    
    const bottomBar = document.getElementById('bottom-bar');
    const bottomBarCartCount = document.getElementById('bottom-bar-cart-count');
    const bottomBarTotal = document.getElementById('bottom-bar-total');
    const bottomBarSubmitBtn = document.getElementById('bottom-bar-submit-btn');
    const orderForm = document.getElementById('order-form');

    const cartCount = document.getElementById('cart-count');
    const emptyCartMessage = document.getElementById('empty-cart-message');

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-item-btn') || e.target.closest('.add-item-btn')) {
            const button = e.target.closest('.add-item-btn');
            const id = button.dataset.id;
            const name = button.dataset.name;
            const price = parseFloat(button.dataset.price);
            
            let existingRow = document.querySelector(`#order-items tr[data-id='${id}']`);
            if (existingRow) {
                let quantityInput = existingRow.querySelector('.quantity-input');
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateRowSubtotal(existingRow);
            } else {
                if (emptyCartMessage) emptyCartMessage.style.display = 'none';
                
                const newRow = document.createElement('tr');
                newRow.dataset.id = id;
                newRow.innerHTML = `
                    <td><strong>${name}</strong><input type="hidden" name="items[]" value="${id}"></td>
                    <td>
                        <div class="input-group" style="width: 130px;">
                            <button class="btn btn-danger decrease-qty" type="button">-</button>
                            <input type="text" name="quantities[]" class="form-control quantity-input text-center" value="1" min="1" readonly>
                            <button class="btn btn-success increase-qty" type="button">+</button>
                        </div>
                    </td>
                    <td class="price">₹${price.toFixed(2)}</td>
                    <td class="subtotal">₹${price.toFixed(2)}</td>
                    <input type="hidden" name="subtotals[]" class="subtotal-input" value="${price.toFixed(2)}">
                    <td><button type="button" class="btn btn-danger btn-sm remove-item-btn"><i class="bi bi-trash"></i></button></td>
                `;
                orderItemsTbody.appendChild(newRow);
            }
            updateGrandTotal();
        }
    });
    
    orderItemsTbody.addEventListener('click', function(e) {
        const target = e.target;
        
        if (target.classList.contains('increase-qty')) {
            const input = target.parentElement.querySelector('.quantity-input');
            input.value = parseInt(input.value) + 1;
            updateRowSubtotal(target.closest('tr'));
            updateGrandTotal();
        }

        if (target.classList.contains('decrease-qty')) {
            const input = target.parentElement.querySelector('.quantity-input');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateRowSubtotal(target.closest('tr'));
                updateGrandTotal();
            }
        }
        
        if (target.closest('.remove-item-btn')) {
            target.closest('tr').remove();
            updateGrandTotal();
            if (orderItemsTbody.querySelectorAll('tr[data-id]').length === 0 && emptyCartMessage) {
                emptyCartMessage.style.display = 'table-row';
            }
        }
    });
    
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
    
    bottomBarSubmitBtn.addEventListener('click', function() {
        orderForm.requestSubmit();
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
        
        if (itemCount > 0) {
            bottomBar.classList.remove('hidden');
        } else {
            bottomBar.classList.add('hidden');
        }

        const gst = subTotal * 0.05;
        const grandTotal = subTotal + gst;

        subTotalTh.textContent = '₹' + subTotal.toFixed(2);
        gstTotalTh.textContent = '₹' + gst.toFixed(2);
        grandTotalTh.textContent = '₹' + grandTotal.toFixed(2);
        grandTotalInput.value = grandTotal.toFixed(2);
        cartCount.textContent = itemCount;

        bottomBarCartCount.textContent = itemCount;
        bottomBarTotal.textContent = '₹' + grandTotal.toFixed(2);
    }
});
</script>
<?= $this->endSection() ?>
