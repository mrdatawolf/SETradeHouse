@php
$serverId = ( empty($currentUser->server_id)) ? 1 : $currentUser->server_id;
@endphp
<span class="activeServer {{ $generalStaleClass }}">
    {{ \App\Models\Servers::find($serverId)->title ?? '' }}
</span>
