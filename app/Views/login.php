<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-5" style="max-width: 400px;">
    <h2>Přihlášení</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('/login') ?>" method="post">
        <div class="mb-3">
            <label class="form-label">Uživatelské jméno</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Heslo</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Přihlásit</button>
    </form>
</div>

<div style="height:40px;"></div>

<div class="aboutme">
    © <?= date('Y') ?> Achievo |
    <a href="<?= base_url('about') ?>" style="color:#aaa; text-decoration:none;">
        O webu
    </a>
</div>

<?= $this->endSection() ?>
