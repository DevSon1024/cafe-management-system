<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-12 text-center my-5">
            <h1 class="display-4">Welcome to The Code Cafe</h1>
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
                    <?php if (!empty($categories)): ?>
                        <div class="accordion" id="menuAccordion">
                            <?php foreach($categories as $category): ?>
                                <?php if (isset($menu_by_category[$category['id']]) && !empty($menu_by_category[$category['id']])): ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-<?= $category['id'] ?>">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $category['id'] ?>" aria-expanded="false" aria-controls="collapse-<?= $category['id'] ?>">
                                                <?= esc($category['name']) ?>
                                            </button>
                                        </h2>
                                        <div id="collapse-<?= $category['id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= $category['id'] ?>" data-bs-parent="#menuAccordion">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <?php foreach($menu_by_category[$category['id']] as $item): ?>
                                                        <div class="col-md-4 mb-4">
                                                            <div class="card h-100">
                                                                <img src="/uploads/<?= esc($item['image']) ?>" class="card-img-top" alt="<?= esc($item['name']) ?>" style="height: 200px; object-fit: cover;">
                                                                <div class="card-body">
                                                                    <h5 class="card-title"><?= esc($item['name']) ?></h5>
                                                                    <p class="card-text">₹<?= number_format($item['price'], 2) ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
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