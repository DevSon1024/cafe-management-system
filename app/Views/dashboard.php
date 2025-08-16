<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
    <h1 class="mb-4">Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Today's Sales</h5>
                    <p class="card-text fs-4 text-white fw-bold">₹<?= number_format($todays_sales, 2) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Pending Orders</h5>
                    <p class="card-text fs-4 text-white fw-bold"><?= $pending_orders ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Menu Items</h5>
                    <p class="card-text fs-4 text-white fw-bold"><?= $total_menu_items ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Available Tables</h5>
                    <p class="card-text fs-4 text-white fw-bold"><?= $available_tables ?></p>
                </div>
            </div>
        </div>
    </div>
    

    <div class="row mt-4">
        <div class="col-md-12">
            <h4>Quick Actions</h4>
            <a href="/orders/new" class="btn btn-info">New Order</a>
            <a href="/admin/sales" class="btn btn-info">View Sales History</a>
            <a href="/admin/menu/new" class="btn btn-info">Add Menu Item</a>
            <a href="/admin/tables" class="btn btn-info">Manage Tables</a>
            <a href="/admin/staff" class="btn btn-info">Manage Staff</a>
        </div>
    </div>

     <div class="row mt-4">
        <div class="col-md-12">
            <h4>Sales History (Last 7 Days)</h4>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($daily_sales as $sale): ?>
                            <tr>
                                <td><?= date('d M, Y', strtotime($sale['sale_date'])) ?></td>
                                <td>₹<?= number_format($sale['total_sales'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>