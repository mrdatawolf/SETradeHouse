@php
$serverId = ( empty($currentUser->server_id)) ? 1 : $currentUser->server_id;
@endphp
<span class="activeServer">
    {{ \App\Models\Servers::find($serverId)->title ?? '' }}
</span>
