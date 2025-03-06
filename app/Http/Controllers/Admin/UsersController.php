<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Team\TeamRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $userRepository;
    protected $permissionRepository;
    protected $teamRepository;

    public function __construct(UserRepository $userRepository, PermissionRepository $permissionRepository, TeamRepository $teamRepository)
    {
        $this->userRepository = $userRepository;
        $this->permissionRepository = $permissionRepository;
        $this->teamRepository = $teamRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('search');

        if (!empty($keyword)) {
            $users = $this->userRepository->getUserByNameOrEmail($keyword);
        } else {
            $users = $this->userRepository->getUsers();
        }

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $teams = $this->teamRepository->getTeams();
        $getPermission = $this->permissionRepository->getPermissions();
        $permissions = [];
        foreach ($getPermission as $permission) {
            $explode = explode('/', $permission->prefix);
            $prefix = $explode[1];

            $permissions[$prefix][] = $permission;
        }

        return view('admin.users.create', compact('teams', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required',
                'address' => 'required|string',
                'phone_number' => 'required',
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
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'security_key' => $securityKey
        ];

        $user = $this->userRepository->create($dataInsert);

        $user->permission()->sync($request->route_ids);

        return redirect()->route('users.list')->with('success', __('Thêm nhân viên thành công!'));
    }

    public function edit($id)
    {
        $user = $this->userRepository->findUsers($id);
        $teams = $this->teamRepository->getTeams();
        $getPermission = $this->permissionRepository->getPermissions();
        $permissions = [];
        foreach ($getPermission as $permission) {
            $explode = explode('/', $permission->prefix);
            $prefix = $explode[1];

            $permissions[$prefix][] = $permission;
        }

        return view('admin.users.edit', compact('user', 'teams', 'permissions'));
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

        $user = $this->userRepository->findOrFail($id);
        $user->update($data);
        $user->syncRoles($request->get('roles'));

        return redirect()->route('users.list')->with('success', __('Cập nhật thông tin nhân viên thành công!'));
    }

    public function destroy($id)
    {
        $this->userRepository->destroy([$id]);

        return redirect()->route('users.list')->with('success', __('Xóa nhân viên thành công!'));
    }
}
