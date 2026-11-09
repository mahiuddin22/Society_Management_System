<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::where('name', 'like', '%' . request()->get('search') . '%')->orWhere('email', 'like', '%' . request()->get('search') . '%')->orWhere('role', 'like', '%' . request()->get('search') . '%')->paginate(10);
        $data['roles'] = Role::all();
        return view('admin.users.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'role'                  => 'required|string|exists:roles,name',
            // 'email'                 => 'required|string|email|max:255|unique:users',
            'username'              => 'required|string|max:255|unique:users',
            'phone'              => 'required|string|max:255|unique:users',
            'password'              => ['required', 'string', 'min:6', 'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9\s]).*$/', 'confirmed'],
            'password_confirmation' => 'required|string|min:6',
        ], [
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.regex' => 'Password must include at least one uppercase letter, one number, and one special character.',
            'password.confirmed' => 'Passwords do not match.',
            'password_confirmation.required' => 'Please confirm your password.',
        ]);

        User::create([
            'name'      => $request->name,
            'role'      => $request->role,
            // 'email'     => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::all();
        return view('admin.users.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'role'  => 'required|string|exists:roles,name',
            // 'email' => 'email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'required|string|max:255|unique:users,phone,' . $user->id,
            'password' => ['nullable', 'string', 'min:6', 'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9\s]).*$/', 'confirmed'],
        ], [
            'password.min' => 'Password must be at least 6 characters.',
            'password.regex' => 'Password must include at least one uppercase letter, one number, and one special character.',
            'password.confirmed' => 'Passwords do not match.',
        ]);

        $user->update([
            'name'  => $request->name,
            'role'  => $request->role,
            // 'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

}
