<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Úkoly</h1>

<?php if (in_array(session()->get('role'), ['admin', 'teacher'])): ?>
<a href="<?= base_url('tasks/add') ?>" class="btn btn-primary mb-3">
    Přidat úkol
</a>
<?php endif; ?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Název</th>
            <th>Popis</th>
            <th>Termín</th>
            <th>Max body</th>
            <th>Status</th>
            <th>Akce</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($tasks)) : ?>
            <?php foreach ($tasks as $task) : ?>

                <?php
                $deadline = strtotime($task['deadline']);
                $now = time();
                $isLate = ($deadline < $now);
                ?>

                <?php if ($task['status'] === 'done' && $isLate) continue; ?>

                <tr class="<?= $task['status'] === 'done' ? 'table-success' : '' ?>">
                    <td><?= esc($task['title']) ?></td>
                    <td><?= esc($task['description']) ?></td>
                    <td><?= esc($task['deadline']) ?></td>
                    <td><?= esc($task['max_points']) ?></td>

                    <td>
                        <?php if ($task['status'] === 'pending' && $isLate): ?>
                            <span class="badge bg-warning text-dark">Po termínu</span>
                        <?php elseif ($task['status'] === 'pending'): ?>
                            <span class="badge bg-warning text-dark">Nedokončeno</span>
                        <?php elseif ($task['status'] === 'done'): ?>
                            <span class="badge bg-success">Dokončeno</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($task['status'] === 'pending'): ?>
                            <a href="<?= base_url('tasks/done/' . $task['id']) ?>" 
                               class="btn btn-success btn-sm mb-1">
                                Dokončit
                            </a>
                        <?php endif; ?>

                        <?php if (in_array(session()->get('role'), ['admin', 'teacher'])): ?>
                            <a href="<?= base_url('points/task/' . $task['id']) ?>" 
                               class="btn btn-primary btn-sm mb-1">
                                Ohodnotit
                            </a>
                        <?php endif; ?>

                        <a href="<?= base_url('tasks/archive/' . $task['id']) ?>" 
                           class="btn btn-outline-secondary btn-sm"
                           onclick="return confirm('Opravdu chceš archivovat tento úkol?')">
                            Archivovat
                        </a>
                    </td>
                </tr>

            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6" class="text-center">Žádné úkoly zatím nejsou.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>