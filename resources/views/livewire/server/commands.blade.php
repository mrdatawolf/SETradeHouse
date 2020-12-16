<div class="card">
    <div class="card-header">Commands for @livewire('active-server')</div>
    <div class="card-body">
        <ul>
            @foreach($commands as $command)
                <li>{{ $command['message'] }} - {{ $command['description'] }}</li>
            @endforeach
        </ul>
    </div>
</div>
