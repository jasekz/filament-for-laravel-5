<?php
namespace App\Http\Controllers\Admin;

use App\Services\Role;
use App\Services\Permission;
use App\Exceptions\ValidationException;
use App\Exceptions\NotFoundException;
use Auth;
use Config;
use Exception;
use Input;

class RoleController extends AdminController {

    /**
     * Constructor
     *
     * @param App\Services\Role $role            
     */
    public function __construct(Role $role, Permission $permission)
    {
        parent::__construct();
        
        $this->middleware('auth.admin:manage-roles');
        
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * List entries
     *
     * @return Response
     */
    public function index()
    {
        try {
            $show = Input::get('showEntries') ? Input::get('showEntries') : Config::get('app.paginationLimit');
            $params['entries'] = $this->role->all(Input::all())->paginate($show);
        } 

        catch (Exception $e) {
            return redirect(route('admin.dashboard'))->with('msgType', trans('app.msgTypeError'))->with('msg', trans('app.genericError'));
        }
        
        $params['crumbs'] = '<a href="' . route('admin.dashboard') . '">Home</a> >> ' . trans('app.accessControl') . ' >> ' . trans('app.roles');
        $params['active'] = 'access-control';
        
        return view('admin.roles.index', $params);
    }

    /**
     * Display 'create new' screen
     *
     * @return Response
     */
    public function create()
    {
        try {
            $params['permissions'] = $this->permission->all()->get();
        } 

        catch (Exception $e) {
            return redirect(route('admin.dashboard'))->with('msgType', trans('app.msgTypeError'))->with('msg', trans('app.genericError'));
        }
        
        $params['crumbs'] = '<a href="' . route('admin.dashboard') . '">' . trans('app.home') . '</a> >> ' . trans('app.accessControl') . ' >> <a href="' . route('admin.roles.index') . '">' . trans('app.roles') . '</a> >>' . trans('app.addNew');
        $params['active'] = 'roles';
        
        return view('admin.roles.create', $params);
    }

    /**
     * Display 'edit' screen
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $params['entry'] = $this->role->find($id);
            $params['permissions'] = $this->permission->all()->get();
        } 

        catch (Exception $e) {
            return redirect(route('admin.dashboard'))->with('msgType', trans('app.msgTypeError'))->with('msg', trans('app.genericError'));
        }
        
        $params['crumbs'] = '<a href="' . route('admin.dashboard') . '">' . trans('app.home') . '</a> >> ' . trans('app.accessControl') . ' >> <a href="' . route('admin.roles.index') . '">' . trans('app.roles') . '</a> >>' . trans('app.edit');
        $params['active'] = 'roles';
        
        return view('admin.roles.edit', $params);
    }

    /**
     * Save entry
     *
     * @return Response
     */
    public function store()
    {
        try {
            $res = $this->role->store(Input::all());
        } 

        catch (NotFoundException $e) {
            return $this->ajaxErrors($e->getErrors(), trans('app.genericError'));
        } 

        catch (ValidationException $e) {
            return $this->ajaxErrors($e->getErrors(), trans('app.correctErrors'));
        } 

        catch (Exception $e) {
            die($e->getMessage());
            return $this->ajaxError(trans('app.genericError'));
        }
        
        switch (Input::get('action')) {
            
            case 'saveAndExit':
                return $this->ajaxSuccess(trans('app.genericSuccess'), [
                    'redirect' => Input::get('redirect')
                ]);
                break;
            
            default:
                return $this->ajaxSuccess(trans('app.genericSuccess'), [
                    'reload' => true
                ]);
                break;
        }
    }

    /**
     * Delete entry
     * 
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $this->role->delete($id);
            
            return $this->ajaxSuccess(trans('app.genericSuccess'), [
                'redirect' => route('admin.roles.index')
            ]);
        } 

        catch (Exception $e) {
            return $this->ajaxError(trans('app.genericError'));
        }
    }
}
