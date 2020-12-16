<div class="card">
    <div class="card-header">Welcome to @livewire('active-server')</div>
    <div class="card-body">
        <ul>
            @foreach($welcomeMessages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

    </div>
</div>
