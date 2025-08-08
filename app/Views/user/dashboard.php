<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">Welcome, <?= session()->get('name') ?>!</h1>
    <p>This is your user dashboard. From here, you can place new orders, view your order history, and manage your profile.</p>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Place a New Order</h5>
                    <p class="card-text">Ready to order something delicious? Select a table and browse our menu.</p>
                    <a href="/orders/new" class="btn btn-primary">Start New Order</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">View Order History</h5>
                    <p class="card-text">Check out your past orders and see what you've enjoyed before.</p>
                    <a href="/user/orders" class="btn btn-info">My Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>