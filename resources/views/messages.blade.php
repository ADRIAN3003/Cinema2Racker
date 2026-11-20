<x-layout title="Üzenetek">
    <h1 class="h3 mb-3">Üzenetek</h1>

    @if ($total === 0)
        <div class="alert alert-info">Még nem érkezett üzenet.</div>
    @else
        <p class="text-body-secondary mb-3">Összesen {{ $total }} üzenet érkezett.</p>

        @foreach ($messages as $message)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $message->subject }}</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">
                        {{ $message->name }}
                        &middot;
                        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                        &middot;
                        {{ $message->created_at->format('Y.m.d. H:i') }}
                    </h6>
                    <p class="card-text">{!! nl2br(e($message->message)) !!}</p>
                </div>
            </div>
        @endforeach

        {{ $messages->links('pagination::bootstrap-5') }}
    @endif
</x-layout>
