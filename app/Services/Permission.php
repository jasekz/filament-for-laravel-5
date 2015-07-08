<?php
namespace App\Services;

use App\Models\Permission as PermissionModel;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use Exception;

class Permission extends Base {
    
    protected $model = null;
    
    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->model = new PermissionModel();
    }

    /**
     * Get permission
     *
     * @param int $id
     * @return App\Permission
     */
    public function find($id)
    {
        return PermissionModel::find($id);
    }

    /**
     * Store permission
     *
     * @param array $permissionData            
     * @throws NotFoundException, ValidationException
     * @return \App\Models\PermissionModel
     */
    public function store($permissionData)
    {        
        try {
            if(array_get($permissionData, 'id')) {
                $permission = PermissionModel::findOrFail((int) array_get($permissionData, 'id'))->fill($permissionData);
                              
            } else {
                $permission = new PermissionModel;
                $permission->fill($permissionData);
            }
        } 

        catch (Exception $e) {
            throw new NotFoundException(trans('app.notFound'));
        }

        if (! $permission->validate()) {
            throw new ValidationException(trans('app.correctErrors'), $permission->errors()->toArray());
        }
        
        try {
            $permission->save();
        } 

        catch (Exception $e) {
            throw $e;
        }
        
        return $permission;
    }
    
    /**
     * Delete permission
     * 
     * @param int $id
     * @throws SaveException
     */
    public static function delete($id)
    {
        try {
            $permission = PermissionModel::find($id);
            $permission->delete();
        }   
        
        catch (Exception $e) {
            throw $e;
        }
    }
}