<?php namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use BaseModelTrait;
    
    /**
     * The attributes that are mass assignable.
     * THIS IS REQUIRED, EVEN IF EMPTY
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
        'description',
    ];

    /**
     * Validation rules
     * THIS IS REQUIRED, EVEN IF EMPTY
     * 
     * @var array
     */
    protected $rules = [
        'name' => 'required',
        'display_name' => 'required',
    ];
    
    /**
     * Validation messages
     * THIS IS REQUIRED, EVEN IF EMPTY
     * 
     * @var array
     */
    protected $messages = [];
}