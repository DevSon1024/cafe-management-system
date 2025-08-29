<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Cashier Dashboard</h2>
<div class="list-group">
    <a href="/cashier/sales" class="list-group-item list-group-item-action">View Sales History</a>
    <a href="/orders/new" class="list-group-item list-group-item-action">Place New Order</a>
</div>
<?= $this->endSection() ?>