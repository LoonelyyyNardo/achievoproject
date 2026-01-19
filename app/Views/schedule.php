<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Rozvrh</h1>

<?php if (!empty($user['schedule_image'])): ?>
    <div class="card shadow-sm p-3">
        <img src="<?= base_url('uploads/schedules/' . $user['schedule_image']) ?>"
             class="img-fluid"
             alt="Rozvrh">
    </div>
<?php else: ?>
    <div class="alert alert-info">
        Rozvrh zatím nebyl nahrán.
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
