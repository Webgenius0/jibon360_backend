<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'moderator')->where('id', '!=', auth()->id())->get();
        return view('backend.layout.moderator.index', compact('users'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('backend.layout.moderator.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'permissions' => 'required|array|min:1',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'moderator',
            'email_verified_at' => now(),
        ]);

        $user->permissions()->sync($validatedData['permissions']);

        return redirect()->route('moderator.edit', $user->id)->with('success', 'Moderator Created Successfully');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $permissions = Permission::all();
        return view('backend.layout.moderator.edit', compact('user', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'permissions' => 'sometimes|required|array|min:1',
        ]);

        $user = User::findOrFail($id);

        if(isset($validatedData['name'])) $user->name = $validatedData['name'];
        $user->save();

        if(isset($validatedData['permissions'])) $user->permissions()->sync($validatedData['permissions']);

        return redirect()->route('moderator.edit', $user->id)->with('success', 'Moderator Updated Successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('moderator.index')->with('success', 'Moderator Deleted Successfully');
    }
}
