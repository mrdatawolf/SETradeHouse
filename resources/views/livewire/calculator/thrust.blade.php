<div>
    <div class="card-columns">
        <div class="card">
            <div class="card-header">
                <h2>Weight Options</h2>
            </div>
            <div class="card-body">
                @livewire('calculator.weight-options')
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2>Thrust Options</h2>
            </div>
            <div class="card-body">
                @livewire('calculator.thrust-options')
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2>Initial thrusters</h2>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
    <div class="card-columns">
        <div class="card">
            <div class="card-header">
                <h2>General Info</h2>
            </div>
            <div class="card-body">
                <label for="gravity">
                    Gravity:
                </label>
                <input wire:model="gravity" id="info-gravity" type="text" readonly>
                <br>
                <label for="planet-id">
                    Planet Name:
                </label>
                <input wire:model="planetName" id="info-planet-id" type="text" readonly>
                <br>
                <label for="ship-size">
                    Grid type:
                </label>
                <input wire:model="shipSize" id="info-ship-size" type="text" readonly>
                <br>
                <label for="cargo-mass">
                    Cargo's mass:
                </label>
                <input wire:model="cargoMass" id="info-cargo-mass" type="text" readonly>
                <br>
                <label for="dry-mass">
                    Ship dry mass:
                </label>
                <input wire:model="dryMass" id="info-dry-mass" type="text" readonly>
                <br>
                <label for="newtons-required">
                    Newtons Required:
                </label>
                <input wire:model="newtonsRequired" id="info-newtons-required" type="text" readonly>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2>Thruster Info</h2>
            </div>
            <div class="card-body">
                <label for="thruster-type">Type:</label>
                <input wire:model="thrusterType" id="thruster-type" type="text" readonly>
                <br>
                <label for="thruster-size">Size:</label>
                <input wire:model="thrusterSize" id="thruster-size" type="text" readonly>
                <br>
                <label for="thrusters-required">Number required:</label>
                <input wire:model="numberThrustersRequired" id="thrusters-required" type="text" readonly>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2>Reactor Info</h2>
            </div>
            <div class="card-body">
                <label for="large-reactors-required">Number large required:</label>
                <input wire:model="numberLargeReactorsRequired" id="large-reactors-required" type="text" readonly>
                <br>
                <label for="small-reactors-required">Number small required:</label>
                <input wire:model="numberSmallReactorsRequired" id="small-reactors-required" type="text" readonly>
                <br>
                <label for="naquadah-reactors-required">Number Naquadah required:</label>
                <input wire:model="numberSpecialReactorsRequired" id="naquadah-reactors-required" type="text" readonly>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2>How long it takes to acheive</h2>
            </div>
            <div class="card-body">
                <label for="ten-meters-per-second">10 m/s:</label>
                <input wire:model="metersPerSecond.ten" id="ten-meters-per-second" type="text" readonly>
                <br>
                <label for="twenty-five-meters-per-second">25 m/s:</label>
                <input wire:model="metersPerSecond.twentyFive" id="twenty-five-meters-per-second" type="text" readonly>
                <br>
                <label for="fifty-meters-per-second">50 m/s:</label>
                <input wire:model="metersPerSecond.fifty" id="fifty-meters-per-second" type="text" readonly>
                <br>
                <label for="one-hundered-meters-per-second">100 m/s:</label>
                <input wire:model="metersPerSecond.oneHundered" id="one-hundered-meters-per-second" type="text" readonly>
                <br>
                <label for="one-hundered-fifty-meters-per-second">150 m/s:</label>
                <input wire:model="metersPerSecond.oneHunderedFifty" id="one-hundered-fifty-meters-per-second" type="text" readonly>
                <br>
                <label for="two-hundered-fifty-meters-per-second">250 m/s:</label>
                <input wire:model="metersPerSecond.twoHunderedFifty" id="two-hundered-fifty-meters-per-second" type="text" readonly>
                <br>
                <label for="five-hundered-meters-per-second">500 m/s:</label>
                <input wire:model="metersPerSecond.fiveHundered" id="five-hundered-meters-per-second" type="text" readonly>
                <br>
                <label for="thousand-meters-per-second">1000 m/s:</label>
                <input wire:model="metersPerSecond.thousand" id="thousand-meters-per-second" type="text" readonly>
            </div>
        </div>
    </div>
</div>
