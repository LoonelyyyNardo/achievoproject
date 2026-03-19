<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="cs">
<body>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="mb-0">Žebříček studentů</h3>
        </div>
        <div class="card-body">

            <?php if (!empty($students)): ?>
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jméno</th>
                            <th>Email</th>
                            <th>Body</th>
                            <th>Počet úkolů</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rank = 1; ?>
                        <?php foreach ($students as $student): ?>
                            <tr class="<?= $rank <= 3 ? 'table-success' : '' ?>">

                                <td><?= $rank++ ?></td>
                                <td><?= esc($student['username']) ?></td>
                                <td><?= esc($student['email']) ?></td>
                                <td><strong><?= esc($student['total_points']) ?></strong></td>
                                <td><?= esc($student['scored_tasks']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning mb-0">
                    Žádní studenti nebyli nalezeni.
                </div>
            <?php endif; ?>

            <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary mt-3">Zpět na dashboard</a>

        </div>
    </div>
</div>

</body>
</html>

<?= $this->endSection() ?>