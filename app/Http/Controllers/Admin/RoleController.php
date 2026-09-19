<?php

namespace Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::with(['permissions', 'users'])->withCount('users')->get();
        $permissions = Permission::all();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        return redirect()->route('admin.roles.index')->with('success', "Role '{$role->name}' created successfully!");
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:roles,name,' . $role->id],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        // Guard Super Admin name change if needed
        if ($role->name === 'Super Admin' && $validated['name'] !== 'Super Admin') {
            return back()->with('error', 'Super Admin role name cannot be modified.');
        }

        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()->route('admin.roles.index')->with('success', "Role '{$role->name}' updated successfully!");
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        if (in_array($role->name, ['Super Admin', 'Admin', 'Telecaller'])) {
            return back()->with('error', "Default system role '{$role->name}' cannot be deleted.");
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', "Cannot delete role '{$role->name}' because it currently has {$role->users()->count()} assigned user(s).");
        }

        $roleName = $role->name;
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', "Role '{$roleName}' deleted successfully.");
    }
}
