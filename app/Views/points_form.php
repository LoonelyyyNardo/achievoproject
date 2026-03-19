<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Udělění bodů</title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/lux/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

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

            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="mb-0">Udělení bodů</h3>
                </div>
                <div class="card-body">

                    <p><strong>Úkol:</strong> <?= esc($task['title']) ?></p>
                    <p><strong>Student:</strong> <?= esc($student['username']) ?></p>
                    <p><strong>Maximum bodů:</strong> <?= esc($task['max_points']) ?></p>

                    <form action="<?= base_url('/points/save') ?>" method="post">
                        <?= csrf_field() ?>

                        <input type="hidden" name="task_id" value="<?= esc($task['id']) ?>">
                        <input type="hidden" name="user_id" value="<?= esc($student['id']) ?>">

                        <div class="mb-3">
                            <label for="points" class="form-label">Počet bodů</label>
                            <input
                                type="number"
                                name="points"
                                id="points"
                                class="form-control"
                                min="0"
                                max="<?= esc($task['max_points']) ?>"
                                value="<?= isset($existingPoints['points']) ? esc($existingPoints['points']) : '' ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Poznámka</label>
                            <textarea
                                name="note"
                                id="note"
                                class="form-control"
                                rows="4"
                            ><?= isset($existingPoints['note']) ? esc($existingPoints['note']) : '' ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Uložit body</button>
                        <a href="<?= base_url('/tasks') ?>" class="btn btn-secondary">Zpět</a>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>

<?= $this->endSection() ?>