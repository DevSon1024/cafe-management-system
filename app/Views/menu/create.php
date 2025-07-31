<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Add New Menu Item</h2>
<form action="/menu" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name" class="form-label">Item Name</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" name="price" required>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <!-- THIS IS THE UPDATED PART -->
        <select name="category_id" class="form-select" required>
            <option value="">-- Select Category --</option>
            <?php foreach($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" name="image">
    </div>
    <button type="submit" class="btn btn-success">Save Item</button>
</form>
<?= $this->endSection() ?>