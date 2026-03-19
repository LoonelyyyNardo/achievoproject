<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2>Správa uživatelů</h2>

<hr>

<h4>Vytvořit uživatele</h4>

<form method="post" action="<?= base_url('admin/create-user') ?>">

    <div class="mb-3">
        <label>Uživatelské jméno</label>
        <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>E-mail</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Heslo</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Role</label>
        <select name="role" class="form-control" required>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <button class="btn btn-primary">Vytvořit uživatele</button>

</form>

<hr>

<h4>Seznam uživatelů</h4>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['email']) ?></td>
                <td><?= esc($user['role']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>