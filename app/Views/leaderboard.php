<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Žebříček studentů</h1>

<div class="card shadow-sm">
    <div class="card-body">

        <?php if (!empty($users)): ?>
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Jméno</th>
                        <th>Body</th>
                        <th>Počet úkolů</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $rank = 1; ?>
                    <?php foreach ($users as $user): ?>

                        <tr class="
                            <?= $rank === 1 ? 'gold' : '' ?>
                            <?= $rank === 2 ? 'silver' : '' ?>
                            <?= $rank === 3 ? 'bronze' : '' ?>
                        ">

                            <td>
                                <?php if ($rank === 1): ?>
                                    🥇
                                <?php elseif ($rank === 2): ?>
                                    🥈
                                <?php elseif ($rank === 3): ?>
                                    🥉
                                <?php else: ?>
                                    <?= $rank ?>
                                <?php endif; ?>
                            </td>

                            <td><?= esc($user['username']) ?></td>
                            

                            <td class="text-end">
                                <strong><?= esc($user['total_points']) ?></strong>
                            </td>

                            <td><?= esc($user['scored_tasks']) ?></td>

                        </tr>

                        <?php $rank++; ?>
                    <?php endforeach; ?>

                </tbody>
            </table>

        <?php else: ?>
            <div class="alert alert-warning mb-0">
                Žádní studenti nebyli nalezeni.
            </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>