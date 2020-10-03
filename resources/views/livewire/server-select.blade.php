<div>
    <x-jet-label value="Server" for="server" />
    <select class="block mt-1 w-full" name="server">
    @foreach(\App\Models\Servers::all() as $server)
        <option value="{{ $server->id }}">{{ $server->title }}</option>
    @endforeach
    </select>
</div>
