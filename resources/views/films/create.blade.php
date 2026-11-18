<x-layout title="Új film">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h3 mb-3">Új film</h1>
            <div class="card">
                <div class="card-body p-4">
                    @include('films._form', ['action' => route('films.store'), 'submit' => 'Létrehozás'])
                </div>
            </div>
        </div>
    </div>
</x-layout>
