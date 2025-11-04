<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Úkoly</h1>

<a href="<?= base_url('tasks/add') ?>" class="btn btn-success mb-3">+ Přidat úkol</a>

<table class="table table-striped table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Název</th>
            <th>Popis</th>
            <th>Termín</th>
            <th>Stav</th>
            <th>Akce</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($tasks)): ?>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= esc($task['title']) ?></td>
                    <td><?= esc($task['description']) ?></td>
                    <td><?= esc($task['deadline']) ?></td>
                    <td>
                        <?php if ($task['status'] == 'completed'): ?>
                            <span class="badge bg-success">Hotovo</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Čeká</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($task['status'] != 'completed'): ?>
                            <a href="<?= base_url('tasks/complete/'.$task['id']) ?>" class="btn btn-sm btn-primary">Hotovo</a>
                        <?php endif; ?>
                        <a href="<?= base_url('tasks/delete/'.$task['id']) ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Opravdu chceš tento úkol smazat?');">
                           Smazat
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center">Žádné úkoly k zobrazení.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
