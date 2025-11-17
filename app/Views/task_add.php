<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1>Přidat nový úkol</h1>

<form action="<?= base_url('/tasks/store') ?>" method="post" class="mt-3">
    <div class="mb-3">
        <label for="title" class="form-label">Název úkolu</label>
        <input type="text" name="title" id="title" class="form-control w-50" style="border: 2px solid #1e1e1eff;" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Popis</label>
        <textarea name="description" id="description" class="form-control" style="border: 2px solid #1e1e1eff;"></textarea>
    </div>

    <div class="mb-3">
        <label for="deadline" class="form-label">Termín</label>
        <input type="date" name="deadline" id="deadline" class="form-control form-control-sm w-25" style="border: 2px solid #1e1e1eff;">
    </div>

    <button type="submit" class="btn btn-primary">Uložit</button>
    <a href="<?= base_url('/tasks') ?>" class="btn btn-secondary">Zpět</a>
</form>

<?= $this->endSection() ?>
