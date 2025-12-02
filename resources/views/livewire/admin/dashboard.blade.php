<div>
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Dashboard</h1>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            <!-- STAT CARDS -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalPhoto }}</h3>
                            <p>Total Foto</p>
                        </div>
                        <div class="icon"><i class="fas fa-camera"></i></div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalUser }}</h3>
                            <p>User Terdaftar</p>
                        </div>
                        <div class="icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalReport }}</h3>
                            <p>Laporan Baru</p>
                        </div>
                        <div class="icon"><i class="fas fa-flag"></i></div>
                    </div>
                </div>
            </div>

            <!-- CHARTS -->
            <div class="row">
                <!-- Chart Foto -->
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">📸 Sebaran Kategori Foto</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="categoryChart" height="250"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart Pengguna -->
                <div class="col-md-6">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">👤 Pertumbuhan Pengguna</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="userChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('livewire:initialized', () => {

    /* ===========================
       CHART KATEGORI FOTO (BAR)
       =========================== */
    const labels = @json($chartLabels ?? []);
    const data = @json($chartData ?? []);

    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Jumlah Foto',
                data,
                backgroundColor: 'rgba(60,141,188,0.4)',
                borderColor: 'rgba(60,141,188,1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });

    /* ===========================
       CHART PENGGUNA (LINE)
       ===========================
       - fallback ke [] jika variabel tidak ada
       - atau fallback ke chartLabels jika kamu ingin tampilkan kategori sebagai sumbu X
    */
    const userLabels = @json($monthLabels ?? []);       // <-- aman jika kosong
    const userData   = @json($usersByMonth ?? []);

    // Jika tak ada data, jangan inisialisasi chart (opsional)
    if ((userLabels.length === 0) && (userData.length === 0)) {
        // Tidak ada data pengguna — skip membuat chart
        return;
    }

    new Chart(document.getElementById('userChart'), {
        type: 'line',
        data: {
            labels: userLabels,
            datasets: [{
                label: 'Pengguna Baru',
                data: userData,
                borderColor: 'rgba(40,167,69,1)',
                backgroundColor: 'rgba(40,167,69,0.25)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });

});
</script>
