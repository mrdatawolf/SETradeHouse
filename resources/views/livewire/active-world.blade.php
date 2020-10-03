<span class="activeServer">
    {{ \App\Models\Worlds::find((int) Session::get('worldId'))->title ?? '' }}
</span>
