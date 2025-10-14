<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Vítej, <?= esc($user['username']) ?></h1>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-center shadow-sm border-primary">
            <div class="card-body">
                <h5 class="card-title">Úkoly</h5>
                <p class="display-6"><?= count($tasks) ?></p>
                <a href="<?= base_url('tasks') ?>" class="btn btn-primary">Zobrazit úkoly</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center shadow-sm border-success">
            <div class="card-body">
                <h5 class="card-title">Body</h5>
                <p class="display-6"><?= $points ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <?php foreach($tasks as $index => $task): ?>
        <?php $colClass = $index === 0 ? 'col-md-6' : 'col-md-3'; ?>
        <div class="<?= $colClass ?>">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= esc($task['title']) ?></h5>
                    <p class="card-text"><?= esc($task['description']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
