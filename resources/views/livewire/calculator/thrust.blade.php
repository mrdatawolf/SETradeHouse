<div>
    <form class="w-full max-w-sm">
        <div class="md:flex md:items-left mb-1">
            @livewire('ship-size')
        </div>
        <div class="md:flex md:items-left-auto mb-6">
            @livewire('cargo-mass')
        </div>
        <div class="md:flex md:items-center mb-6">
            @livewire('dry-mass')
        </div>
        <div class="md:flex md:items-center mb-6">
            @livewire('planet-select')
        </div>

        <div class="md:w-1/3">
            <label for="gravity">
                Gravity:
            </label>
            <input wire:model="gravity" id="gravity" type="text" readonly>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <label for="planet-id">
                planet-id:
            </label>
            <input wire:model="planetId" id="planet-id" type="text" readonly>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <label for="ship-size">
                ship-size:
            </label>
            <input wire:model="shipSize" id="ship-size" type="text" readonly>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <label for="cargo-mass">
                cargo-mass:
            </label>
            <input wire:model="cargoMass" id="cargo-mass" type="text" readonly>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <label for="dry-mass">
                dry-mass:
            </label>
            <input wire:model="dryMass" id="dry-mass" type="text" readonly>
            <label for="newtons-required">
                newtons-required:
            </label>
            <input wire:model="newtonsRequired" id="newtons-required" type="text" readonly>
        </div>

        <div class="md:flex md:items-center mb-6">
            <h2>Small</h2>
            <table>
                <thead>
                <tr>
                    <th>
                        Type
                    </th>
                    <th>
                        Size
                    </th>
                    <th>
                        # required
                    </th>
                    <th>
                        Large reactors Needed
                    </th>
                    <th>
                        Small reactors Needed
                    </th>
                    <th>
                        Naquadah reactors needed
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($thrusters as $thruster)
                    @livewire('calculator.ship.thrusters.table.row', [$thruster])
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>
