<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Place New Order</h2>

<form action="/orders/create" method="post" id="order-form">
    <?= csrf_field() ?>

    <div class="row">
        <div class="col-md-4">
            <h4>Details</h4>
            <div class="mb-3">
                <label for="table_id" class="form-label">Select Table</label>
                <select name="table_id" class="form-select" required>
                    <option value="">-- Choose Table --</option>
                    <?php foreach($tables as $table): ?>
                        <option value="<?= $table['id'] ?>"><?= esc($table['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <hr>
            <button type="submit" class="btn btn-success w-100">Place Order</button>
        </div>

        <div class="col-md-8">
            <h4>Menu</h4>
            <div class="row">
                <?php foreach($menu_items as $item): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="/uploads/<?= $item['image'] ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title"><?= esc($item['name']) ?></h6>
                            <p class="card-text">₹<?= number_format($item['price'], 2) ?></p>
                            <button type="button" class="btn btn-sm btn-primary add-item-btn" 
                                    data-id="<?= $item['id'] ?>" 
                                    data-name="<?= esc($item['name']) ?>"
                                    data-price="<?= $item['price'] ?>">Add to Order</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <hr>
    <h4>Current Order</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="order-items">
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Grand Total:</th>
                <th id="grand-total">₹0.00</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="grand_total" id="grand-total-input" value="0">
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addItemButtons = document.querySelectorAll('.add-item-btn');
    const orderItemsTbody = document.getElementById('order-items');
    const grandTotalTh = document.getElementById('grand-total');
    const grandTotalInput = document.getElementById('grand-total-input');

    addItemButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);

            // Check if item already exists
            const existingRow = document.querySelector(`#order-items tr[data-id='${id}']`);
            if (existingRow) {
                const quantityInput = existingRow.querySelector('.quantity-input');
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateRowSubtotal(existingRow);
            } else {
                const newRow = document.createElement('tr');
                newRow.dataset.id = id;
                newRow.innerHTML = `
                    <td>
                        ${name}
                        <input type="hidden" name="items[]" value="${id}">
                    </td>
                    <td>
                        <input type="number" name="quantities[]" class="form-control quantity-input" value="1" min="1" style="width: 70px;">
                    </td>
                    <td class="price">${price.toFixed(2)}</td>
                    <td class="subtotal">${price.toFixed(2)}</td>
                    <input type="hidden" name="subtotals[]" class="subtotal-input" value="${price.toFixed(2)}">
                    <td><button type="button" class="btn btn-danger btn-sm remove-item-btn">Remove</button></td>
                `;
                orderItemsTbody.appendChild(newRow);
            }
            updateGrandTotal();
        });
    });

    orderItemsTbody.addEventListener('change', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            const row = e.target.closest('tr');
            updateRowSubtotal(row);
            updateGrandTotal();
        }
    });

    orderItemsTbody.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item-btn')) {
            e.target.closest('tr').remove();
            updateGrandTotal();
        }
    });

    function updateRowSubtotal(row) {
        const price = parseFloat(row.querySelector('.price').textContent);
        const quantity = parseInt(row.querySelector('.quantity-input').value);
        const subtotal = price * quantity;
        row.querySelector('.subtotal').textContent = subtotal.toFixed(2);
        row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
    }

    function updateGrandTotal() {
        let total = 0;
        document.querySelectorAll('#order-items .subtotal').forEach(subtotalEl => {
            total += parseFloat(subtotalEl.textContent);
        });
        grandTotalTh.textContent = '₹' + total.toFixed(2);
        grandTotalInput.value = total.toFixed(2);
    }
});
</script>
<?= $this->endSection() ?>