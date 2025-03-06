<?php

namespace App\Http\Controllers;

use App\Helper\Common;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Team\TeamRepository;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    protected $teamRepository;
    protected $permissionRepository;

    public function __construct(TeamRepository $teamRepository, PermissionRepository $permissionRepository)
    {
        $this->teamRepository  = $teamRepository;
        $this->permissionRepository  = $permissionRepository;
    }

    public function index()
    {
        $teams = $this->teamRepository->getTeams();
        $teams = Common::paginate($teams);

        return view('admin.team.index', compact('teams'));
    }

    public function create()
    {
        $getPermission = $this->permissionRepository->getPermissions();
        $permissions = [];
        foreach ($getPermission as $permission) {
            $explode = explode('/', $permission->prefix);
            $prefix = $explode[1];
            
            $permissions[$prefix][] = $permission;
        }

        return view('admin.team.create', compact('permissions'));
    }
}
