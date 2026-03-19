<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hodnocení studentů</title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/lux/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="mb-0">Hodnocení studentů k úkolu</h3>
        </div>
        <div class="card-body">
            <p><strong>Úkol:</strong> <?= esc($task['title']) ?></p>
            <p><strong>Maximum bodů:</strong> <?= esc($task['max_points']) ?></p>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($students)): ?>
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Email</th>
                            <th>Aktuální body</th>
                            <th>Akce</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?= esc($student['username']) ?></td>
                                <td><?= esc($student['email']) ?></td>
                                <td>
                                    <?= $student['awarded_points'] !== null ? esc($student['awarded_points']) : 'Zatím nehodnoceno' ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('/points/form/' . $task['id'] . '/' . $student['id']) ?>" class="btn btn-primary btn-sm">
                                        Ohodnotit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning mb-0">
                    K tomuto úkolu nejsou přiřazeni žádní studenti.
                </div>
            <?php endif; ?>

            <a href="<?= base_url('/tasks') ?>" class="btn btn-secondary mt-3">Zpět</a>
        </div>
    </div>
</div>

</body>
</html>