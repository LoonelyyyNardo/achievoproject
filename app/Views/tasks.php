<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Seznam úkolů</h1>

<div class="list-group">
    <?php foreach($tasks as $task): ?>
        <div class="list-group-item mb-2 shadow-sm">
            <h5><?= esc($task['title']) ?></h5>
            <p><?= esc($task['description']) ?></p>
        </div>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
