<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Add New Table</h2>
<form action="/tables" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name" class="form-label">Table Name / Number</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="Available">Available</option>
            <option value="Occupied">Occupied</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?= $this->endSection() ?>