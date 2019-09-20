<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Storage;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:users,id',
            'path' => 'image|max:500'
        ];
    }

    public function updateUser(User $user)
    {
        $dir = date('Y.m');

        if ($this->hasFile('path'))
            Storage::disk('public')->delete($user->path);

        $user->update([
            'name' => $this->input('name'),
            'email' => $this->input('email'),
            'path' => $this->hasFile('path') ? Storage::disk('public')->put('users_' . $dir, $this->file('path')) : $user->path
        ]);
        $user->roles()->sync($this->input('roles'));

        return redirect()->route('users.index')->with('message', 'użytkownik ' . $user->name . ' został edytowany');
    }
}
