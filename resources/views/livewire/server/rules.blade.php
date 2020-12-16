<div class="card">
    <div class="card-header">Rules for @livewire('active-server')</div>
    <div class="card-body">
        <ul>
            @foreach($rulesMessages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
</div>
