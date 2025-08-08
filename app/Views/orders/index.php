<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Active Orders</h2>
<a href="/orders/new" class="btn btn-primary mb-3">Place New Order</a>
<?php if(session()->get('status')): ?>
    <div class="alert alert-success"><?= session()->get('status') ?></div>
<?php endif; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Table</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= esc($order['table_name']) ?></td>
            <td>₹<?= number_format($order['total_amount'], 2) ?></td>
            <td><span class="badge bg-<?= $order['status'] == 'Pending' ? 'warning' : 'success' ?>"><?= $order['status'] ?></span></td>
            <td><?= date('d-m-Y H:i', strtotime($order['created_at'])) ?></td>
            <td>
                <a href="/orders/receipt/<?= $order['id'] ?>" class="btn btn-sm btn-info">View Bill</a>

                <?php if ($order['status'] == 'Pending'): ?>
                    <form action="/orders/complete/<?= $order['id'] ?>" method="post" class="d-inline">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-success">Complete</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>