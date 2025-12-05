<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Order History</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Bill No.</th>
            <th>Table</th>
            <th>Status</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($orders as $order): ?>
        <tr>
            <td>
                <a class="btn btn-sm btn-light" data-bs-toggle="collapse" href="#orderItems<?= $order['id'] ?>" role="button" aria-expanded="false" aria-controls="orderItems<?= $order['id'] ?>">
                    <i class="bi bi-eye"></i> <?= $order['id'] ?>
                </a>
            </td>
            <td><?= $order['order_type'] === 'take_away' ? 'Take Away Order' : esc($order['table_name']) ?></td>
            <td><span class="badge bg-success"><?= $order['status'] ?></span></td>
            <td><?= date('d-m-Y H:i', strtotime($order['created_at'])) ?></td>
        </tr>
        <tr class="collapse" id="orderItems<?= $order['id'] ?>">
            <td colspan="4">
                <div class="card card-body">
                    <h5>Order Items</h5>
                    <ul>
                        <?php foreach($order['items'] as $item): ?>
                            <li><?= esc($item['item_name']) ?> - Quantity: <?= $item['quantity'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>