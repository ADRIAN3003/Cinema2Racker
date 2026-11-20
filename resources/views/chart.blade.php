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
        <script>
            var chartData = {
                mufajLabels: @json($mufajLabels),
                mufajValues: @json($mufajValues),
                topMozikLabels: @json($topMozikLabels),
                topMozikValues: @json($topMozikValues),
                szinesLabels: @json($szinesLabels),
                szinesValues: @json($szinesValues),
                szarmazasLabels: @json($szarmazasLabels),
                szarmazasValues: @json($szarmazasValues)
            };
        </script>
    </x-slot:scripts>
</x-layout>
