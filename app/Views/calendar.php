<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Kalendář</h1>

<div class="ratio ratio-16x9 shadow-sm">
    <iframe
        src="https://calendar.google.com/calendar/embed?src=4ab31f238accb71904953e5427eb411b5a052725da59905328afa80b7af469ae%40group.calendar.google.com&ctz=Europe%2FPrague"
        style="border:0"
        loading="lazy">
    </iframe>
</div>

<?= $this->endSection() ?>
