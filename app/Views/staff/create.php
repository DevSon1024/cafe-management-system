<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Add New Staff Member</h2>
<form action="/staff" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select name="role" class="form-select" required>
            <option value="Admin">Admin</option>
            <option value="Cashier">Cashier</option>
            <option value="Waiter">Waiter</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="shift" class="form-label">Shift</label>
        <select name="shift" class="form-select" required>
            <option value="Morning">Morning</option>
            <option value="Evening">Evening</option>
            <option value="Night">Night</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?= $this->endSection() ?>