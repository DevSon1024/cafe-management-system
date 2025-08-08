<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Edit Staff Member</h2>
<form action="/staff/<?= $staff_member['id'] ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" value="<?= esc($staff_member['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select name="role" class="form-select" required>
            <option value="Admin" <?= $staff_member['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
            <option value="Cashier" <?= $staff_member['role'] == 'Cashier' ? 'selected' : '' ?>>Cashier</option>
            <option value="Waiter" <?= $staff_member['role'] == 'Waiter' ? 'selected' : '' ?>>Waiter</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="shift" class="form-label">Shift</label>
        <select name="shift" class="form-select" required>
            <option value="Morning" <?= $staff_member['shift'] == 'Morning' ? 'selected' : '' ?>>Morning</option>
            <option value="Evening" <?= $staff_member['shift'] == 'Evening' ? 'selected' : '' ?>>Evening</option>
            <option value="Night" <?= $staff_member['shift'] == 'Night' ? 'selected' : '' ?>>Night</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
<?= $this->endSection() ?>