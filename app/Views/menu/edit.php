<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Edit Menu Item</h2>
<form action="/admin/menu/<?= $item['id'] ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">
    <div class="mb-3">
        <label for="name" class="form-label">Item Name</label>
        <input type="text" class="form-control" name="name" value="<?= esc($item['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" name="price" value="<?= esc($item['price']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <!-- THIS IS THE UPDATED PART -->
        <select name="category_id" class="form-select" required>
            <?php foreach($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= ($category['id'] == $item['category_id']) ? 'selected' : '' ?>>
                    <?= esc($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image (leave blank to keep current)</label>
        <input type="file" class="form-control" name="image">
        <img src="/uploads/<?= $item['image'] ?>" width="100" class="mt-2">
    </div>
    <button type="submit" class="btn btn-primary">Update Item</button>
</form>
<?= $this->endSection() ?>