document.addEventListener('DOMContentLoaded', function() {
    const flash = document.getElementById('flash-msg');
    if (flash) setTimeout(() => flash.remove(), 5000);

    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', e => {
            if (!confirm(el.dataset.confirm)) e.preventDefault();
        });
    });

    document.querySelectorAll('[data-campus-filter]').forEach(sel => {
        sel.addEventListener('change', function() {
            const url = new URL(window.location.href);
            if (this.value) url.searchParams.set('campus', this.value);
            else url.searchParams.delete('campus');
            window.location = url;
        });
    });
});

function openModal(id) {
    document.getElementById(id)?.classList.add('show');
}
function closeModal(id) {
    document.getElementById(id)?.classList.remove('show');
}

function initChart(canvasId, type, labels, data, colors) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;
    new Chart(ctx, {
        type: type,
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors || ['#1e3a5f','#c9a227','#198754','#dc3545','#6c757d','#0dcaf0'],
                borderWidth: type === 'line' ? 2 : 0,
                fill: type === 'line',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
}
