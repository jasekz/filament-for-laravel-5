<?php
namespace App\Services;

use App\Models\User as UserModel;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Exceptions\SaveException;
use Exception;

class User extends Base {
    
    protected $model = null;
    
    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->model = new UserModel();
    }

    /**
     * Get user
     *
     * @param int $id
     * @return App\User
     */
    public function find($id)
    {
        return UserModel::find($id);
    }

    /**
     * Store user
     *
     * @param array $data            
     * @throws NotFoundException, ValidationException
     * @return \App\Models\UserModel
     */
    public function store($data)
    {
        if( ! array_get($data, 'password')) {
            unset($data['password']);
        }
        
        try {
            if(array_get($data, 'id')) {
                $user = UserModel::findOrFail((int) array_get($data, 'id'));
                
                // if this user's email is the same as what the data, then it's ok; otherwise, it has to be unique
                if(array_get($data, 'email') && $user->email == array_get($data, 'email')) {
                    $user->removeRule('email');
                }  
                
                $user->fill($data);
                              
            } else {
                $user = new UserModel;
                $user->fill($data);
            }
        } 

        catch (Exception $e) {
            throw new NotFoundException(trans('app.notFound'));
        }
            
        if( ! array_get($data, 'password')) {
            $user->removeRule('password');
        }

        if (! $user->validate()) {
            throw new ValidationException(trans('app.correctErrors'), $user->errors()->toArray());
        }
        
        if(array_get($data, 'password')){        
            $user->password = bcrypt($data['password']);            
        }
        unset($user->password_confirmation);
        
        try {
            $user->save();
        } 

        catch (Exception $e) {
            throw $e;
        }
        
        return $user;
    }
    
    /**
     * Delete user
     * 
     * @param int $id
     * @throws SaveException
     */
    public function delete($id)
    {
        try {
            if($this->isSuperUser($id)) {
                throw new SaveException(trans('app.entryNotDeletable')); // can not delete the 'super admin'
            }
            $user = UserModel::find($id);
            $user->delete();
        }   
        
        catch (Exception $e) {
            throw $e;
        }
    }
    
    /**
     * There is one super user which must remain intact to prevent lock out from the system
     * 
     * @param int $id
     * @return boolean
     */
    public function isSuperUser($id)
    {
        return $id == 1;
    }
}