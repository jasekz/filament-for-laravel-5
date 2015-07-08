<?php
namespace App\Services;

use App\Models\Role as RoleModel;
use App\Models\User as UserModel;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use Exception;

class Role extends Base {

    protected $model = null;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new RoleModel();
    }

    /**
     * Get role
     *
     * @param int $id            
     * @return App\Role
     */
    public function find($id)
    {
        return RoleModel::find($id);
    }

    /**
     * Store role
     *
     * @param array $roleData            
     * @throws NotFoundException, ValidationException
     * @return \App\Models\RoleModel
     */
    public function store($roleData)
    {
        try {
            if (array_get($roleData, 'id')) {
                $role = RoleModel::findOrFail((int) array_get($roleData, 'id'))->fill($roleData);
            } else {
                $role = new RoleModel();
                $role->fill($roleData);
            }
        } 

        catch (Exception $e) {
            throw new NotFoundException(trans('app.notFound'));
        }
        
        if (! $role->validate()) {
            throw new ValidationException(trans('app.correctErrors'), $role->errors()->toArray());
        }
        
        try {
            $role->save();
            
            // associate permissions
            if (array_get($roleData, 'permission_id')) {
                $role->perms()->sync(array_get($roleData, 'permission_id'));
            }
        } 

        catch (Exception $e) {
            throw $e;
        }
        
        return $role;
    }

    /**
     * Delete role
     *
     * @param int $id            
     * @throws SaveException
     */
    public function delete($id)
    {
        try {
            $role = RoleModel::find($id);
            $role->delete();
        } 

        catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Assign roles to user
     * 
     * @param UserModel $user
     * @param array $roles
     * @return void
     */
    public function assignRolesToUser(UserModel $user, $roles = [])
    {
        // first we'll disassociate all roles
        $user->detachRoles($user->roles);
        
        // now we'll re-associate as needed
        if ($roles) {
            $user->roles()->sync($roles);
        }
    }
}