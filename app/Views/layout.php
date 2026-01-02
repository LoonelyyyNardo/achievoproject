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

        <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
            Achievo
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Levá část -->
            <ul class="navbar-nav me-auto">
                <?php if (session()->get('logged_in')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('dashboard') ?>">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('tasks') ?>">
                            Úkoly
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Pravá část -->
            <ul class="navbar-nav align-items-center">
                <?php if (session()->get('logged_in')): ?>

                    <li class="nav-item me-3 text-light">
                        Přihlášen:
                        <strong><?= esc(session()->get('username')) ?></strong>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm"
                           href="<?= base_url('logout') ?>">
                            Odhlásit
                        </a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm"
                           href="<?= base_url('login') ?>">
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
    <div class="alert alert-success mt-3 mx-3">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>
</body>
</html>
