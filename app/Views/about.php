<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-12 text-center my-5">
            <h1 class="display-4">About Us</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Our Details</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Cafe Name:</strong> <?= esc($settings['cafe_name'] ?? 'The Code Cafe') ?></li>
                        <li class="list-group-item"><strong>GST Number:</strong> <?= esc($settings['gst_number'] ?? 'N/A') ?></li>
                        <li class="list-group-item"><strong>Address:</strong> <?= esc($settings['address'] ?? 'Come visit us!') ?></li>
                        <li class="list-group-item"><strong>Phone:</strong> <?= esc($settings['phone'] ?? 'N/A') ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?= esc($settings['email'] ?? 'N/A') ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>