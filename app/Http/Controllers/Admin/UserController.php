<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
       $this->middleware('can:admin.users.index')->only('index');
       $this->middleware('can:admin.users.edit')->only('edit');
       $this->middleware('can:admin.users.update')->only('update');
    }

    public function index()
    {
        //
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //

        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $user->update($request->all());

        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.edit', $user)->with('info', 'Se asigno el rol correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
