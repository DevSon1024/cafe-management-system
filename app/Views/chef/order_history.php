<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Order History</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Table</th>
            <th>Status</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= $order['order_type'] === 'take_away' ? 'Take Away Order' : esc($order['table_name']) ?></td>
            <td><span class="badge bg-success"><?= $order['status'] ?></span></td>
            <td><?= date('d-m-Y H:i', strtotime($order['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>