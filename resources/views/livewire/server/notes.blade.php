<div class="card">
    <div class="card-header">Notes for @livewire('active-server')</div>
    <div class="card-body">
        <ul>
            @foreach($notes as $note)
                <li>{{ $note }}</li>
            @endforeach
        </ul>
    </div>
</div>
