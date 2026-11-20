<x-layout title="Diagram">
    <h1 class="h3 mb-1">Diagram</h1>
    <p class="text-body-secondary mb-4">Összesen {{ $filmCount }} film és {{ $moziCount }} mozi található az adatbázisban.</p>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Filmek száma műfajonként</div>
                <div class="card-body" style="height: 320px">
                    <canvas id="chartMufaj" aria-label="Filmek száma műfajonként oszlopdiagram"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">A 10 legtöbb filmet játszó mozi</div>
                <div class="card-body" style="height: 320px">
                    <canvas id="chartMozik" aria-label="A 10 legtöbb filmet játszó mozi vízszintes oszlopdiagram"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Színes és fekete-fehér filmek aránya</div>
                <div class="card-body" style="height: 320px">
                    <canvas id="chartSzines" aria-label="Színes és fekete-fehér filmek aránya fánkdiagram"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">A 8 leggyakoribb származás</div>
                <div class="card-body" style="height: 320px">
                    <canvas id="chartSzarmazas" aria-label="A 8 leggyakoribb származás tortadiagram"></canvas>
                </div>
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
        <script>
            Chart.defaults.color = '#adb5bd';
            Chart.defaults.borderColor = 'rgba(255,255,255,0.1)';

            new Chart(document.getElementById('chartMufaj'), {
                type: 'bar',
                data: {
                    labels: @json($mufajLabels),
                    datasets: [{
                        label: 'Filmek száma',
                        data: @json($mufajValues),
                        backgroundColor: 'rgba(13,110,253,0.7)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });

            new Chart(document.getElementById('chartMozik'), {
                type: 'bar',
                data: {
                    labels: @json($topMozikLabels),
                    datasets: [{
                        label: 'Vetített filmek',
                        data: @json($topMozikValues),
                        backgroundColor: 'rgba(25,135,84,0.7)'
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });

            new Chart(document.getElementById('chartSzines'), {
                type: 'doughnut',
                data: {
                    labels: @json($szinesLabels),
                    datasets: [{
                        data: @json($szinesValues),
                        backgroundColor: ['rgba(255,193,7,0.8)', 'rgba(108,117,125,0.8)']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            new Chart(document.getElementById('chartSzarmazas'), {
                type: 'pie',
                data: {
                    labels: @json($szarmazasLabels),
                    datasets: [{
                        data: @json($szarmazasValues),
                        backgroundColor: [
                            'rgba(13,110,253,0.7)',
                            'rgba(25,135,84,0.7)',
                            'rgba(255,193,7,0.7)',
                            'rgba(220,53,69,0.7)',
                            'rgba(13,202,240,0.7)',
                            'rgba(111,66,193,0.7)',
                            'rgba(253,126,20,0.7)',
                            'rgba(102,16,242,0.7)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
    </x-slot:scripts>
</x-layout>
