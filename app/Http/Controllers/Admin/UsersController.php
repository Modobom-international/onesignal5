<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;

        if (!empty($keyword)) {
            $users = User::where('name', 'LIKE', "%$keyword%")->orWhere('email', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $users = User::latest()->paginate($perPage);
        }

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::get();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required',
            ]
        );

        $data = $request->except('password');
        $passwordPlain = $request->get('password');
        $securityKey = hash('sha256', $passwordPlain);
        $data['password'] = bcrypt($request->password);
        $dataInsert = [
            'name' => $request->name,
            'email' => $request->email,
            'type' => 'user',
            'password' => $data['password'],
            'security_key' => $securityKey
        ];

        $user = User::create($dataInsert);

        $user->syncRoles($request->get('roles'));

        return redirect('admin/users')->with('success', 'User added!');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user = $user;
        $userRole = $user->roles->pluck('name')->toArray();
        $roles = Role::get();
        return view('admin.users.edit', [
            'user' => $user,
            'userRole' => $userRole,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|string|max:255|email|unique:users,email,' . $id,
            ]
        );

        $data = $request->except('password');
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user = User::findOrFail($id);
        $user->update($data);
        $user->syncRoles($request->get('roles'));

        return redirect('admin/users')->with('success', 'User updated!');
    }

    public function destroy($id)
    {
        User::destroy($id);

        return redirect('admin/users')->with('success', 'User deleted!');
    }

    public function changePasswordUser($id)
    {
        $dataUser = DB::table('users')->where('id', $id)->first();
        return view('admin.users.change-password-user', compact('dataUser'));
    }

    public function updatePasswordUser(Request $request, $id)
    {
        $dataUser = DB::table('users')->where('id', $id)->first();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, $dataUser->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }

        User::whereId($dataUser->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("success", "Password changed successfully!");
    }

    public function changePassword()
    {
        return view('admin.users.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("success", "Password changed successfully!");
    }
}
