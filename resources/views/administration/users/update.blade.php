@extends('layouts.app')
@section('title', 'Update a user')

@section('content')
    <div id="app" class="flex-center position-ref full-height">
        <div class="card">
            <div class="card-header">Create a Server</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.servers.add') }}">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" aria-describedby="titleHelp" placeholder="Enter title">
                        <small id="titleHelp" class="form-text text-muted">The full name of the server</small>
                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="short_hand">Abreviation</label>
                        <input type="text" class="form-control @error('short_name') is-invalid @enderror" name="short_name" id="shortHand" aria-describedby="short_handHelp" placeholder="Enter abreviation">
                        <small id="short_handHelp" class="form-text text-muted">A short version of the full title</small>
                        @error('short_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="scarcityIdFormControlSelect">Scarcity Type</label>
                        <select class="form-control @error('scarcity_id') is-invalid @enderror" name="scarcity_id" id="scarcityIdFormControlSelect" aria-describedby="scarcityHelp">
                            @foreach(\App\Scarcity::all() as $scarcity)
                            <option value="{{ $scarcity->id }}">{{ $scarcity->title }}</option>
                            @endforeach
                        </select>
                        <small id="scarcityHelp" class="form-text text-muted">How is scarcity defined on the server? "worlds": scaricity is determined by the number of worlds with the good. transactions: how many of a good are available in transactions. </small>
                        @error('scarcity_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="economyOreIdFormControlSelect">Economy Ore</label>
                        <select class="form-control @error('economy_ore_id') is-invalid @enderror" name="economy_ore_id" id="economyOreIdFormControlSelect" aria-describedby="economyOreIdHelp">
                            @foreach(\App\Models\Ores::all() as $ore)
                                <option value="{{ $ore->id }}"  @if($ore->id === 13) selected @endif >{{ $ore->title }}</option>
                            @endforeach
                        </select>
                        <small id="economyOreIdHelp" class="form-text text-muted">Which Ore is the lynchpin of the market?  defaults to Space credits. </small>
                        @error('economy_ore_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="economyOreValue">Economy Ore Value</label>
                        <input type="text" class="form-control @error('economy_ore_value') is-invalid @enderror" name="economy_ore_value" id="economyOreValue" aria-describedby="economyOreValueHelp" value="1">
                        <small id="economyOreValueHelp" class="form-text text-muted">An integer value. Normally 1.</small>
                        @error('economy_ore_value')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="economyStoneModifier">Economy Stone Modifier</label>
                        <input type="text" class="form-control @error('economy_stone_modifier') is-invalid @enderror" name="economy_stone_modifier" id="economyStoneModifier" aria-describedby="economyStoneModifierHelp" value="0">
                        <small id="economyStoneModifierHelp" class="form-text text-muted">When assigning a value to stones how should the server push the price of stone? This is an integrer value. defaults to 0.</small>
                        @error('economy_stone_modifier')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="scalingModifier">Scaling Modifier</label>
                        <input type="text" class="form-control @error('scaling_modifier') is-invalid @enderror" name="scaling_modifier" id="scalingModifier" aria-describedby="scalingModifierHelp" value="10">
                        <small id="scalingModifierHelp" class="form-text text-muted">If scarcity is defined by worlds this calculates how each world with a good effects the scaling. Defaults to 10.</small>
                        @error('scaling_modifier')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="asteroidScalingModifier">Asteroid Scarcity Modifier</label>
                        <input type="text" class="form-control @error('asteroid_scarcity_modifier') is-invalid @enderror" name="asteroid_scarcity_modifier" id="asteroidScalingModifier" aria-describedby="asteroidScalingModifierHelp" value="1">
                        <small id="asteroidScalingModifierHelp" class="form-text text-muted">If a good is on an asteroid how much should it adjust the scarcity. Defaults to 1.</small>
                        @error('asteroid_scarcity_modifier')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="asteroidScalingModifier">Planet Scarcity Modifier</label>
                        <input type="text" class="form-control @error('planet_scarcity_modifier') is-invalid @enderror" name="planet_scarcity_modifier" id="planetScalingModifier" aria-describedby="planetScalingModifierHelp" value="2">
                        <small id="planetScalingModifierHelp" class="form-text text-muted">If a good is on a planet how much should it adjust the scarcity. Defaults to 2.</small>
                        @error('planet_scarcity_modifier')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="baseModifier">Base Modifier</label>
                        <input type="text" class="form-control @error('base_modifier') is-invalid @enderror" name="base_modifier" id="baseModifier" aria-describedby="baseModifierHelp" value="1">
                        <small id="baseModifierHelp" class="form-text text-muted">This allows you to skew base modifier value. Defaults to 1.</small>
                        @error('base_modifier')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
@endsection
