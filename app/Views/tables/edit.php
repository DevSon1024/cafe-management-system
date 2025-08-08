<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Edit Table</h2>
<form action="/tables/<?= $table['id'] ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">
    <div class="mb-3">
        <label for="name" class="form-label">Table Name / Number</label>
        <input type="text" class="form-control" name="name" value="<?= esc($table['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="Available" <?= $table['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
            <option value="Occupied" <?= $table['status'] == 'Occupied' ? 'selected' : '' ?>>Occupied</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
<?= $this->endSection() ?>