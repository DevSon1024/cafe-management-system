<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <!-- Welcome Header -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="text-gradient mb-3">Welcome back, <?= session()->get('name') ?>! ☕</h1>
            <p class="lead text-muted">Ready to explore our delicious menu and place your next order?</p>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
            <div class="card dashboard-card hover-lift h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-plus-circle-fill" style="font-size: 3rem; color: var(--success-color);"></i>
                    </div>
                    <h5 class="card-title">Place New Order</h5>
                    <p class="card-text">Browse our menu and create a new order. Fresh ingredients, amazing taste!</p>
                    <a href="/orders/new" class="btn btn-success btn-lg">
                        <i class="bi bi-cart-plus me-2"></i>Start Ordering
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="card dashboard-card hover-lift h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-clock-history" style="font-size: 3rem; color: var(--info-color);"></i>
                    </div>
                    <h5 class="card-title">Order History</h5>
                    <p class="card-text">View your past orders and reorder your favorite items with just one click.</p>
                    <a href="/user/orders" class="btn btn-info btn-lg">
                        <i class="bi bi-list-ul me-2"></i>My Orders
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
            <div class="card dashboard-card hover-lift h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-circle" style="font-size: 3rem; color: var(--primary-color);"></i>
                    </div>
                    <h5 class="card-title">My Profile</h5>
                    <p class="card-text">Update your personal information and manage your account settings.</p>
                    <a href="/user/profile" class="btn btn-primary btn-lg">
                        <i class="bi bi-gear me-2"></i>Manage Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats or Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card glass-effect">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-info-circle me-2"></i>Quick Tips
                    </h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-lightning-charge text-warning me-2"></i>
                                <small class="text-muted">Orders are typically ready in 15-20 minutes</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-star-fill text-warning me-2"></i>
                                <small class="text-muted">Try our daily specials for the best experience</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-heart-fill text-danger me-2"></i>
                                <small class="text-muted">Save your favorites for quick reordering</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>