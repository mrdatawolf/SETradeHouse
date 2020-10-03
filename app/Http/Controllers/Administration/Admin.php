<?php namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\OwnerServer;
use App\Models\Servers;
use App\Models\User;
use App\Models\Worlds;
use Redirect;
use \Illuminate\Http\Request;

class Admin extends Controller
{
    public function worldsIndex()
    {
        $worlds = Worlds::all();

        return view('administration.worlds.index', compact('worlds'));
    }


    public function ownersIndex()
    {
        $owners = OwnerServer::all();

        return view('administration.users.owners', compact('owners'));
    }

    public function createWorld()
    {
        $isAdmin = \Auth::user()->roles()->where('title', 'Admin')->exists();
        if ($isAdmin) {
            return view('administration.worlds.create');
        } else {
            return Redirect::back()->withErrors(['msg', 'Not Authorized!']);
        }
    }


    public function serversIndex()
    {
        $servers = Servers::all();

        return view('administration.servers.index', compact('servers'));
    }


    //this gets the data from the user we need
    public function createServer()
    {
        $isAdmin = \Auth::user()->roles()->where('title', 'Admin')->exists();
        if ($isAdmin) {
            return view('administration.servers.create');
        } else {
            return Redirect::back()->withErrors(['msg', 'Not Authorized!']);
        }
    }


    //this take sthe user supplied data and adds the server to the table.
    public function addServer(Request $request)
    {
        $isAdmin = \Auth::user()->roles()->where('title', 'Admin')->exists();
        if ($isAdmin) {
            $validatedData = $request->validate([
                'title'                      => 'required|max:50',
                'scarcity_id'                => 'required|integer|max:2',
                'economy_ore_id'             => 'required|integer|max:30',
                'economy_stone_modifier'     => 'required|integer|max:10',
                'scaling_modifier'           => 'required|integer|max:10',
                'economy_ore_value'          => 'required|integer|max:30',
                'asteroid_scarcity_modifier' => 'required|integer|max:10',
                'planet_scarcity_modifier'   => 'required|integer|max:10',
                'base_modifier'              => 'required|integer|max:10',
                'short_name'                 => 'required|string|max:5',
            ]);
            $server = new Servers();
            $server->title = $request->title;
            $server->scarcity_id = $request->scarcity_id;
            $server->economy_ore_id = $request->economy_ore_id;
            $server->economy_stone_modifier = $request->economy_stone_modifier;
            $server->scaling_modifier = $request->scaling_modifier;
            $server->economy_ore_value = $request->economy_ore_value;
            $server->asteroid_scarcity_modifier = $request->asteroid_scarcity_modifier;
            $server->planet_scarcity_modifier = $request->planet_scarcity_modifier;
            $server->base_modifier = $request->base_modifier;
            $server->short_name = $request->short_name;
            $server->save();
            $servers = Servers::all();

            return view('administration.servers.index', compact('servers'));
        } else {
            return Redirect::back()->withErrors(['msg', 'Not Authorized!']);
        }
    }

    //this take sthe user supplied data and adds the server to the table.
    public function addWorld(Request $request)
    {
        $isAdmin = \Auth::user()->roles()->where('title', 'Admin')->exists();
        if ($isAdmin) {
            $validatedData = $request->validate([
                'title'                      => 'required|max:50',
                'server_id'                  => 'required|integer|max:2',
                'type_id'                    => 'required|integer|max:10',
                'system_stock_weight'        => 'required|integer|max:10',
                'short_name'                 => 'required|string|max:5',
            ]);
            $world = new Worlds();
            $world->title = $request->title;
            $world->server_id = $request->server_id;
            $world->type_id = $request->type_id;
            $world->system_stock_weight = $request->system_stock_weight;
            $world->short_name = $request->short_name;
            $world->save();
            $worlds = Worlds::all();

            return view('administration.worlds.index', compact('worlds'));
        } else {
            return Redirect::back()->withErrors(['msg', 'Not Authorized!']);
        }
    }


    public function usersIndex() {
        $isAdmin = \Auth::user()->roles()->where('title', 'Admin')->exists();
        if ($isAdmin) {
            $users = User::all();
        }
        return view('administration.users.index', compact('users'));
    }

    public function updateUser() {
        $isAdmin = \Auth::user()->roles()->where('title', 'Admin')->exists();
        if ($isAdmin) {
            $users = User::all();
        }
        return view('administration.users.update', compact('users'));
    }

    public function doUpdateUser() {
        $isAdmin = \Auth::user()->roles()->where('title', 'Admin')->exists();
        if ($isAdmin) {
            $users = User::all();
        }
        return view('administration.users.doUpdate', compact('users'));
    }
}
