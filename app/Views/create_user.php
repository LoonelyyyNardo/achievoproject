<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">Vytvořit nového uživatele</h2>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= base_url('admin/users/store') ?>" class="card p-4 shadow-sm">

    <div class="mb-3">
        <label class="form-label">Uživatelské jméno</label>
        <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Heslo</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
            <option value="student">Student</option>
            <option value="teacher">Učitel</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <button class="btn btn-primary">
        Vytvořit uživatele
    </button>

</form>

<?= $this->endSection() ?>
