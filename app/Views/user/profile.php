<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">My Profile</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Profile Information</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Name:</strong> <?= esc(session()->get('name')) ?></li>
                <li class="list-group-item"><strong>Email:</strong> <?= esc(session()->get('email')) ?></li>
                <li class="list-group-item"><strong>Role:</strong> <?= ucfirst(esc(session()->get('role'))) ?></li>
            </ul>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order History</h5>
                    <p class="card-text">This is where your past orders will be displayed.</p>
                    <a href="/user/orders" class="btn btn-primary">View My Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>