<div class="card">
    <div class="card-header">Info for @livewire('active-server')</div>
    <div class="card-body">
        <ul>
            @foreach($informationMessages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
</div>
