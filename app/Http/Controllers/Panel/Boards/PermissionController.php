<?php

namespace App\Http\Controllers\Panel\Boards;

use App\Board;
use App\Permission;
use App\PermissionGroup;
use App\Role;
use App\Http\Controllers\Panel\PanelController;
use Input;
use Validator;
use Event;
use App\Events\RoleWasModified;

/**
 * Permissions for a role.
 *
 * @category   Controller
 *
 * @author     Joshua Moon <josh@jaw.sh>
 * @copyright  2016 Infinity Next Development Group
 * @license    http://www.gnu.org/licenses/agpl-3.0.en.html AGPL3
 *
 * @since      0.6.0
 */
class PermissionController extends PanelController
{
    const VIEW_PERMISSIONS = 'panel.roles.permissions.edit';

    /**
     * View path for the secondary (sidebar) navigation.
     *
     * @var string
     */
    public static $navSecondary = 'nav.panel.board';

    /**
     * View path for the tertiary (inner) navigation.
     *
     * @var string
     */
    public static $navTertiary = 'nav.panel.board.settings';

    /**
     * Show the application dashboard to the user.
     *
     * @param \App\Board $board The board we're working with.
     * @param \App\Role  $role  The role being modified.
     *
     * @return Response
     */
    public function getPermissions(Board $board, Role $role)
    {
        if (!$role->canSetPermissions($this->user)) {
            return abort(403);
        }

        $permissionGroups = PermissionGroup::orderBy('display_order', 'asc')->withPermissions()->get();
        $permissionGroups = $permissionGroups->filter(function ($group) {
            $permissions = $group->permissions->filter(function ($permission) {
                return $this->user->can($permission);
            });

            $group->setRelation('permissions', $permissions);

            return $permissions->count();
        });

        return $this->view(static::VIEW_PERMISSIONS, [
            'board' => $board,
            'role' => $role,
            'groups' => $permissionGroups,

            'tab' => 'roles',
        ]);
    }

    /**
     * Commit updates to the role permissions.
     *
     * @param \App\Board $board The board we're working with.
     * @param \App\Role  $role  The role being modified.
     *
     * @return Response
     */
    public function patchPermissions(Board $board, Role $role)
    {
        if (!$role->canSetPermissions($this->user)) {
            return abort(403);
        }

        $input = Input::all();
        $permissions = Permission::all();
        $rolePermissions = [];
        $nullPermissions = [];

        foreach ($permissions as $permission) {
            if ($this->user->can($permission->permission_id)) {
                $nullPermissions[] = $permission->permission_id;

                foreach ($input['permission'] as $permission_id => $permission_value) {
                    $permission_id = str_replace('_', '.', $permission_id);

                    if ($permission->permission_id == $permission_id) {
                        switch ($permission_value) {
                            case 'allow':
                            case 'revoke':
                            case 'deny':
                                $rolePermissions[$permission_id] = [
                                    'role_id' => $role->role_id,
                                    'permission_id' => $permission_id,
                                    'value' => $permission_value == 'allow',
                                ];
                            break;
                        }

                        break;
                    }
                }
            }
        }

        $role->permissions()->detach($nullPermissions);
        $role->permissions()->attach($rolePermissions);

        $permission_groups = PermissionGroup::withPermissions()->get();

        Event::fire(new RoleWasModified($role));

        return $this->view(static::VIEW_PERMISSIONS, [
            'board' => $board,
            'role' => $role,
            'groups' => $permission_groups,

            'tab' => 'roles',
        ]);
    }
}
