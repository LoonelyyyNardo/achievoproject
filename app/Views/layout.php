<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Achievo') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/lux/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .form-control:focus {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.20rem rgba(13, 110, 253, .25) !important;
        }

        .gold {
            background-color: #ffd700 !important;
            color: #000;
            font-size: 1.6rem;
            box-shadow: inset 0 0 0 9999px rgba(255, 215, 0, 0.12), 0 0 14px rgba(255, 215, 0, 0.65);
        }

        .silver {
            background-color: #c0c0c0 !important;
            color: #000;
            font-size: 1.6rem;
            box-shadow: inset 0 0 0 9999px rgba(192, 192, 192, 0.12), 0 0 14px rgba(192, 192, 192, 0.65);
        }

        .bronze {
            background-color: #cd7f32 !important;
            color: #fff;
            font-size: 1.6rem;
            box-shadow: inset 0 0 0 9999px rgba(205, 127, 50, 0.12), 0 0 14px rgba(205, 127, 50, 0.65);
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
        }

        .aboutme {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #000;
            color: #aaa;
            font-size: 0.75rem;
            text-align: center;
            padding: 6px 0;
            z-index: 1000;
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

                        <a class="nav-link" href="<?= base_url('dashboard') ?>">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>

                        <a class="nav-link" href="<?= base_url('tasks') ?>">
                            <i class="fas fa-list-check me-1"></i> Úkoly
                        </a>

                        <a class="nav-link" href="<?= base_url('schedule') ?>">
                            <i class="fas fa-clock me-1"></i> Rozvrh
                        </a>

                        <a class="nav-link" href="<?= base_url('calendar') ?>">
                            <i class="fas fa-calendar me-1"></i> Kalendář
                        </a>

                        <a class="nav-link" href="<?= base_url('points/leaderboard') ?>">
                            <i class="fas fa-trophy me-1"></i> Leaderboard
                        </a>

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