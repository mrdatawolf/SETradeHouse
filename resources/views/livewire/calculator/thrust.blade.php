<div>
    <div class="card-columns">
        <div class="card">
            <div class="card-body">
                <h2>Options</h2>
                @livewire('ship-size')
                @livewire('thruster-size')
                @livewire('thruster-type')
                @livewire('cargo-mass')
                @livewire('dry-mass')
                @livewire('planet-select')
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>General Info</h2>
                <label for="gravity">
                    Gravity:
                </label>
                <input wire:model="gravity" id="gravity" type="text" readonly>
                <br>
                <label for="planet-id">
                    planet-id:
                </label>
                <input wire:model="planetId" id="planet-id" type="text" readonly>
                <br>
                <label for="ship-size">
                    ship-size:
                </label>
                <input wire:model="shipSize" id="ship-size" type="text" readonly>
                <br>
                <label for="cargo-mass">
                    cargo-mass:
                </label>
                <input wire:model="cargoMass" id="cargo-mass" type="text" readonly>
                <br>
                <label for="dry-mass">
                    dry-mass:
                </label>
                <input wire:model="dryMass" id="dry-mass" type="text" readonly>
                <br>
                <label for="newtons-required">
                    newtons-required:
                </label>
                <input wire:model="newtonsRequired" id="newtons-required" type="text" readonly>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Thruster Info</h2>
                <label for="thruster-type">Type:</label>
                <input wire:model="thrusterType" id="thruster-type" type="text" readonly>
                <br>
                <label for="thruster-size">Size:</label>
                <input wire:model="thrusterSize" id="thruster-size" type="text" readonly>
                <br>
                <label for="thrusters-required"># required:</label>
                <input wire:model="numberThrustersRequired" id="thrusters-required" type="text" readonly>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Power Info</h2>
                <label for="large-reactors-required"># Large reactors needed:</label>
                <input wire:model="numberLargeReactorsRequired" id="large-reactors-required" type="text" readonly>
                <br>
                <label for="small-reactors-required"># Small reactors needed:</label>
                <input wire:model="numberSmallReactorsRequired" id="small-reactors-required" type="text" readonly>
                <br>
                <label for="naquadah-reactors-required"> # Naquadah reactors needed:</label>
                <input wire:model="numberNaquadahReactorsRequired" id="naquadah-reactors-required" type="text" readonly>
            </div>
        </div>
    </div>
</div>
