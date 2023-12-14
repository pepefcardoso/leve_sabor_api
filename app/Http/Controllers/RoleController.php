<?php

namespace App\Http\Controllers;

use App\Services\Roles\DeleteRole;
use App\Services\Roles\RegisterRole;
use App\Services\Roles\SearchRoles;
use App\Services\Roles\ShowRole;
use App\Services\Roles\UpdateRole;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function index(SearchRoles $searchRoles)
    {
        $roles = $searchRoles->search();

        return response()->json($roles);
    }

    public function store(Request $request, RegisterRole $registerRole)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:99',
        ]);

        $role = $registerRole->register($data);

        return response()->json($role);
    }

    public function show(ShowRole $showRole, int $id)
    {
        $role = $showRole->show($id);

        return response()->json($role);
    }

    public function update(Request $request, UpdateRole $updateRole, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:99',
        ]);

        $role = $updateRole->update($data, $id);

        return response()->json($role);
    }

    public function destroy(DeleteRole $deleteRole, int $id)
    {
        $role = $deleteRole->delete($id);

        return response()->json($role);
    }
}
