<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
    <h1 class="mb-4">Sales History</h1>

    <!-- Date Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Filter by Date</h5>
            <form action="/admin/sales" method="get">
                <div class="row">
                    <div class="col-md-5">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" value="<?= esc($start_date) ?>">
                    </div>
                    <div class="col-md-5">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" value="<?= esc($end_date) ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sales Data Table -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Sales Report</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sales_data)): ?>
                        <?php foreach($sales_data as $sale): ?>
                        <tr>
                            <td><?= date('F j, Y', strtotime($sale['sale_date'])) ?></td>
                            <td>₹<?= number_format($sale['total_sales'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center">No sales data found for the selected period.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>