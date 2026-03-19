<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Achievo') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/lux/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-control:focus {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.20rem rgba(13, 110, 253, .25) !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary py-3 mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url('dashboard') ?>">
            Achievo
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">
                <?php if (session()->get('logged_in')): ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('tasks') ?>">Úkoly</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('schedule') ?>">Rozvrh</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('calendar') ?>">Kalendář</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('leaderboard') ?>">Leaderboard</a>
                    </li>

                    <?php if (in_array(session()->get('role'), ['admin', 'teacher'], true)): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('tasks/add') ?>">Přidat úkol</a>
                        </li>
                    <?php endif; ?>

                    <?php if (session()->get('role') === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/users') ?>">Správa uživatelů</a>
                        </li>
                    <?php endif; ?>

                <?php endif; ?>
            </ul>

            <ul class="navbar-nav align-items-center">
                <?php if (session()->get('logged_in')): ?>

                    <li class="nav-item me-3 text-light">
                        Přihlášen: <strong><?= esc(session()->get('username')) ?></strong>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="<?= base_url('logout') ?>">
                            Odhlásit
                        </a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm" href="<?= base_url('login') ?>">
                            Přihlášení
                        </a>
                    </li>

                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>

<div class="container">

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

    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>