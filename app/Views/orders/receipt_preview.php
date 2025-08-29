<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container text-center">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <h2>Your receipt is printing...</h2>
    <p>You will be redirected to the final receipt shortly.</p>

    <div class="card mt-4">
        <div class="card-header">
            Receipt Preview
        </div>
        <div class="card-body">
            <p><strong>Order ID:</strong> <?= $order['id'] ?></p>
            <p><strong>Table:</strong> <?= esc($order['table_name']) ?></p>
            <p><strong>Date:</strong> <?= date('d M Y, H:i:s', strtotime($order['created_at'])) ?></p>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $sub_total = 0; ?>
                    <?php foreach($order_items as $item): ?>
                    <tr>
                        <td><?= esc($item['item_name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>₹<?= number_format($item['item_price'], 2) ?></td>
                        <td>₹<?= number_format($item['subtotal'], 2) ?></td>
                    </tr>
                    <?php $sub_total += $item['subtotal']; ?>
                    <?php endforeach; ?>
                </tbody>
               <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Sub-Total:</th>
                        <th>₹<?= number_format($sub_total, 2) ?></th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">GST (5%):</th>
                        <th>₹<?= number_format($sub_total * 0.05, 2) ?></th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Grand Total:</th>
                        <th>₹<?= number_format($sub_total * 1.05, 2) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        window.location.href = '/order/receipt/<?= $order['id'] ?>';
    }, 3000); // 3-second delay
</script>

<?= $this->endSection() ?>