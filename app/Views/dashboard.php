<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
    <h1 class="mb-4">Admin Dashboard</h1>
    <div class="row">
        <!-- Today's Sales Card -->
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Today's Sales</h5>
                    <p class="card-text fs-4">$<?= number_format($todays_sales, 2) ?></p>
                </div>
            </div>
        </div>
        <!-- Pending Orders Card -->
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending Orders</h5>
                    <p class="card-text fs-4"><?= $pending_orders ?></p>
                </div>
            </div>
        </div>
        <!-- Menu Items Card -->
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Menu Items</h5>
                    <p class="card-text fs-4"><?= $total_menu_items ?></p>
                </div>
            </div>
        </div>
        <!-- Available Tables Card -->
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Available Tables</h5>
                    <p class="card-text fs-4"><?= $available_tables ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h4>Quick Actions</h4>
            <a href="/orders/new" class="btn btn-primary">New Order</a>
            <a href="/menu/new" class="btn btn-secondary">Add Menu Item</a>
            <a href="/tables" class="btn btn-info">Manage Tables</a>
        </div>
    </div>
<?= $this->endSection() ?>