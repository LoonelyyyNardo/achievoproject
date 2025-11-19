<!DOCTYPE html>
<html lang="cs">
<style>
    .form-control:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.20rem rgba(13,110,253,.25) !important;
    }
</style>

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Achievo' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/flatly/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>">Achievo</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= base_url('tasks') ?>">Úkoly</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success mt-3 mx-3">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>
</body>
</html>
