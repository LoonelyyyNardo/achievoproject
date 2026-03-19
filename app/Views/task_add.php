<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">Přidat nový úkol</h2>

<form method="post" action="<?= base_url('tasks/store') ?>" class="p-3 border rounded bg-light">

    <div class="mb-3">
        <label for="title" class="form-label">Název úkolu</label>
        <input type="text" name="title" id="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Popis</label>
        <textarea name="description" id="description" class="form-control" rows="4"></textarea>
    </div>

    <div class="mb-3">
        <label for="deadline" class="form-label">Termín splnění</label>
        <input type="date" name="deadline" id="deadline" class="form-control">
    </div>

    <div class="mb-3">
        <label for="max_points" class="form-label">Maximální počet bodů</label>
        <input type="number" name="max_points" id="max_points" class="form-control" min="1" value="10" required>
    </div>

    <div class="mb-3">
        <label for="assign_type" class="form-label">Komu přiřadit</label>
        <select name="assign_type" id="assign_type" class="form-control" required>
            <option value="single">Jednomu uživateli</option>
            <option value="selected">Vybraným uživatelům</option>
            <option value="all">Všem uživatelům</option>
        </select>
    </div>

    <div class="mb-3" id="usersBox">
        <label for="selected_users" class="form-label">Vyber uživatele</label>
        <select name="selected_users[]" id="selected_users" class="form-control" multiple size="8">
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>">
                    <?= esc($user['username']) ?> (<?= esc($user['role']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <small class="text-muted">
            U volby Jednomu uživateli vyber jen jednoho. U volby Vybraným uživatelům můžeš vybrat více položek.
        </small>
    </div>

    <button type="submit" class="btn btn-success">Přidat úkol</button>
    <a href="<?= base_url('tasks') ?>" class="btn btn-secondary">Zpět</a>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const assignType = document.getElementById('assign_type');
    const usersBox = document.getElementById('usersBox');

    function toggleUsersBox() {
        if (assignType.value === 'all') {
            usersBox.style.display = 'none';
        } else {
            usersBox.style.display = 'block';
        }
    }

    assignType.addEventListener('change', toggleUsersBox);
    toggleUsersBox();
});
</script>

<?= $this->endSection() ?>