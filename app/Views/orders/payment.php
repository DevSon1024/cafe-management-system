<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Finalize Your Order</h2>
                </div>
                <div class="card-body">
                    <form action="/order/process_payment" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="order_id" value="<?= $order_id ?>">
                        <input type="hidden" name="order_type" value="<?= $order_type ?>">

                        <?php if ($order_type === 'dine_in'): ?>
                            <div class="mb-3">
                                <label for="table_id" class="form-label">Select Your Table</label>
                                <select name="table_id" id="table_id" class="form-select" required>
                                    <option value="">-- Choose a Table --</option>
                                    <?php foreach ($tables as $table): ?>
                                        <option value="<?= $table['id'] ?>"><?= esc($table['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <div class="text-center">
                            <h4>Total Amount: ₹<?= number_format($total_amount, 2) ?></h4>
                            <p>Please proceed to payment.</p>
                            <button type="submit" class="btn btn-success btn-lg">Pay Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>