<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .menu-carousel-container {
        overflow: hidden;
        position: relative;
        width: 100%;
        padding: 2rem 0;
    }

    .menu-carousel {
        display: flex;
        animation: scroll 40s linear infinite;
    }

    .menu-carousel:hover {
        animation-play-state: paused;
    }

    .menu-card {
        flex: 0 0 auto;
        width: 300px;
        margin: 0 1rem;
        transition: transform 0.3s ease;
    }

    .menu-card:hover {
        transform: scale(1.05);
    }

    @keyframes scroll {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(calc(-300px * <?= count($menu_items) ?>));
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12 text-center my-5">
            <h1 class="display-4">Welcome to <?= esc($cafeName) ?></h1>
            <p class="lead">Your daily dose of code and coffee.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Our Menu</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($menu_items)): ?>
                        <div class="menu-carousel-container">
                            <div class="menu-carousel">
                                <?php foreach(array_merge($menu_items, $menu_items) as $item): ?>
                                    <div class="card menu-card h-100">
                                        <img src="/uploads/<?= esc($item['image']) ?>" class="card-img-top" alt="<?= esc($item['name']) ?>" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= esc($item['name']) ?></h5>
                                            <p class="card-text">₹<?= number_format($item['price'], 2) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-center">No menu items available at the moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0">Ready to Order?</h2>
                </div>
                <div class="card-body text-center">
                    <p>Click the button below to start your order!</p>
                    <a href="/order/new" class="btn btn-success btn-lg">Order Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>