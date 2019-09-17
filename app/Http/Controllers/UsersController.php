<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User, Role};
use App\Http\Requests\UserUpdateRequest;
use Storage;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkAdmin')->only('index', 'update', 'show', 'edit', 'destroy');
    }

    public function index()
    {
        $users = User::with(['articles', 'videos', 'comments', 'larticles', 'lvideos', 'roles'])->orderBy('id', 'asc')->paginate(15);
        return view('users.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => Role::get()
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        return $request->updateUser($user);
    }

    public function destroy(User $user)
    {
        Storage::disk('public')->delete($user->path);
        $user->delete();
        $user->roles()->detach();

        return redirect()->route('users.index')->with('alert', 'użytkownik ' . $user->name . ' został usunięty');
    }
}
