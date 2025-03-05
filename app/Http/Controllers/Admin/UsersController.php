<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 15;

        if (!empty($keyword)) {
            $users = $this->userRepository->getUserByNameOrEmail($keyword);
        } else {
            $users = $this->userRepository->getUsers();
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

        $user = $this->userRepository->create($dataInsert);

        $user->syncRoles($request->get('roles'));

        return redirect('admin/users')->with('success', __('Thêm nhân viên thành công!'));
    }

    public function edit()
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

        return redirect('admin/users')->with('success', __('Cập nhật thông tin nhân viên thành công!'));
    }

    public function destroy($id)
    {
        User::destroy($id);

        return redirect('admin/users')->with('success', __('Xóa nhân viên thành công!'));
    }
}
