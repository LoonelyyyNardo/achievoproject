<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Kalendář</h1>

<div id="calendar"></div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'cs',
        events: "<?= base_url('calendar/events') ?>"
    });

    calendar.render();
});
</script>

<?= $this->endSection() ?>