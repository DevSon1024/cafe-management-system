<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">My Order History</h1>

    <?php if (!empty($orders)): ?>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Table</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $order): ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?></td>
                            <td><?= esc($order['table_name']) ?></td>
                            <td>₹<?= number_format($order['total_amount'], 2) ?></td>
                            <td>
                                <span class="badge bg-<?= $order['status'] == 'Pending' ? 'warning' : 'success' ?>">
                                    <?= esc($order['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="/user/orders/receipt/<?= $order['id'] ?>" class="btn btn-sm btn-info">View Bill</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center p-5 border rounded">
            <p class="lead">You haven't placed any orders yet.</p>
            <p><?= esc($greeting_message) ?></p>
            <a href="/orders/new" class="btn btn-primary mt-3">Place Your First Order</a>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>