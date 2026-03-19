<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Dashboard</h1>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title">Uživatel</h5>
                <p class="mb-0"><?= esc($user['username']) ?></p>
                <small class="text-muted"><?= esc($user['role']) ?></small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title">Počet úkolů</h5>
                <p class="display-6 mb-0"><?= $task_count ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title">Body</h5>
                <p class="display-6 mb-0"><?= $points ?></p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="card-title mb-3">Aktivní úkoly</h5>

        <?php if (!empty($tasks)): ?>
            <ul class="list-group">
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'pending'): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?= esc($task['title']) ?></span>
                            <span class="badge bg-warning text-dark"><?= esc($task['deadline']) ?></span>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="mb-0">Žádné úkoly k zobrazení.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>