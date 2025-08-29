<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h2>How would you like to enjoy your order?</h2>
            <p class="lead">Please select one of the options below.</p>

            <div class="card mt-4">
                <div class="card-body">
                    <form action="/order/process_type" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="order_id" value="<?= $order_id ?>">
                        <div class="d-grid gap-3">
                            <button type="submit" name="order_type" value="dine_in" class="btn btn-primary btn-lg">
                                <i class="bi bi-cup-straw me-2"></i>Eat Here
                            </button>
                            <button type="submit" name="order_type" value="take_away" class="btn btn-success btn-lg">
                                <i class="bi bi-bag-check-fill me-2"></i>Take Away
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>