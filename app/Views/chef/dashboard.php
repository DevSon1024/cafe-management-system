<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Chef Dashboard</h2>
<?php if(session()->get('status')): ?>
    <div class="alert alert-success"><?= session()->get('status') ?></div>
<?php endif; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Table</th>
            <th>Status</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= $order['order_type'] === 'take_away' ? 'Take Away Order' : esc($order['table_name']) ?></td>
            <td><span class="badge bg-<?= $order['status'] == 'Pending' ? 'warning' : ($order['status'] == 'In Making' ? 'info' : 'success') ?>"><?= $order['status'] ?></span></td>
            <td><?= date('d-m-Y H:i', strtotime($order['created_at'])) ?></td>
            <td>
                <form action="/chef/order/update_status/<?= $order['id'] ?>" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <select name="status" class="form-select form-select-sm d-inline w-auto">
                        <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="In Making" <?= $order['status'] == 'In Making' ? 'selected' : '' ?>>In Making</option>
                        <option value="Completed" <?= $order['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>