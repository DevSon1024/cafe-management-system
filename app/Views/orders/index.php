<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>All Orders</h2>
<?php if(session()->get('status')): ?>
    <div class="alert alert-success"><?= session()->get('status') ?></div>
<?php endif; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Bill No.</th>
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
            <td>
                <?php if ($order['order_type'] === 'take_away'): ?>
                    Take Away Order
                <?php else: ?>
                    <?= esc($order['table_name']) ?>
                <?php endif; ?>
            </td>
            <td>₹<?= number_format($order['total_amount'], 2) ?></td>
            <td><span class="badge bg-<?= $order['status'] == 'Pending' ? 'warning' : ($order['status'] == 'In Making' ? 'info' : 'success') ?>"><?= $order['status'] ?></span></td>
            <td><?= date('d-m-Y H:i', strtotime($order['created_at'])) ?></td>
            <td>
                <a href="/admin/orders/receipt/<?= $order['id'] ?>" class="btn btn-sm btn-info">View Bill</a>

                <form action="/admin/orders/update_status/<?= $order['id'] ?>" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                        <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="In Making" <?= $order['status'] == 'In Making' ? 'selected' : '' ?>>In Making</option>
                        <option value="Completed" <?= $order['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                </form>

                <form action="/admin/orders/<?= $order['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
