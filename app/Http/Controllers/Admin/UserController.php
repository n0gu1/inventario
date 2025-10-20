<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('read-users');
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create-users');
        $roles = Role::all(); // ← pasar roles a la vista
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create-users');

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // NUEVO: roles opcionales
            'roles'    => 'nullable|array',
            'roles.*'  => 'integer|exists:roles,id',
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        // NUEVO: asignación de roles (si vienen)
        $user->roles()->sync($request->input('roles', []));

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Usuario creado correctamente',
            'text'  => 'El usuario ha sido creado exitosamente.'
        ]);

        return redirect()->route('admin.users.edit', $user);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('read-users');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update-users');
        $roles = Role::all(); // ← pasar roles a la vista
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('update-users');

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            // NUEVO: roles opcionales
            'roles'    => 'nullable|array',
            'roles.*'  => 'integer|exists:roles,id',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        // NUEVO: sincronizar roles (si no se envía nada, deja sin roles)
        $user->roles()->sync($request->input('roles', []));

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Usuario actualizado correctamente',
            'text'  => 'Los datos del usuario han sido actualizados exitosamente.'
        ]);

        return redirect()->route('admin.users.edit', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete-users');
        $user->delete();

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Usuario eliminado correctamente',
            'text'  => 'El usuario ha sido eliminado exitosamente.'
        ]);

        return redirect()->route('admin.users.index');
    }
}
