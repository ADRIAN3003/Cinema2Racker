<x-layout title="Film szerkesztése">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h3 mb-3">Film szerkesztése</h1>
            <div class="card">
                <div class="card-body p-4">
                    @include('films._form', ['action' => route('films.update', $film), 'submit' => 'Mentés'])
                </div>
            </div>
        </div>
    </div>
</x-layout>
