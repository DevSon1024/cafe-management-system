<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h1 class="mb-4">Cashier Dashboard</h1>
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Today's Sales</h5>
                <p class="card-text fs-4 text-white fw-bold">₹<?= number_format($todays_sales, 2) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Today's Orders Taken</h5>
                <p class="card-text fs-4 text-white fw-bold"><?= $todays_orders ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <h4>Quick Actions</h4>
        <a href="/cashier/orders/new" class="btn btn-lg btn-info">
            <i class="bi bi-plus-circle-fill me-2"></i>New Order
        </a>
        <a href="/cashier/sales" class="btn btn-lg btn-secondary">
            <i class="bi bi-bar-chart-line-fill me-2"></i>View Sales History
        </a>
    </div>
</div>
<?= $this->endSection() ?>