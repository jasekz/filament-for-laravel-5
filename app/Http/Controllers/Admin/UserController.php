<?php
namespace App\Http\Controllers\Admin;

use App\Services\User;
use App\Services\Role;
use App\Exceptions\ValidationException;
use App\Exceptions\NotFoundException;
use App\Exceptions\SaveException;
use Auth;
use Config;
use Exception;
use Input;

class UserController extends AdminController {

    /**
     * Constructor
     *
     * @param App\Services\User $user            
     */
    public function __construct(User $user, Role $role)
    {
        parent::__construct();
        
        $this->middleware('auth.admin:manage-users');
        
        $this->user = $user;
        $this->role = $role;
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
            $params['entries'] = $this->user->all(Input::all())->paginate($show);
        } 

        catch (Exception $e) {
            return redirect(route('admin.dashboard'))->with('msgType', trans('app.msgTypeError'))->with('msg', trans('app.genericError'));
        }
        
        $params['crumbs'] = '<a href="' . route('admin.dashboard') . '">Home</a> >> ' . trans('app.accessControl') . ' >> ' . trans('app.users');
        $params['active'] = 'access-control';
        
        return view('admin.users.index', $params);
    }

    /**
     * Display 'create new' screen
     *
     * @return Response
     */
    public function create()
    {
        try {
            $params['roles'] = $this->role->all()->get();
        } 

        catch (Exception $e) {
            return redirect(route('admin.dashboard'))->with('msgType', trans('app.msgTypeError'))->with('msg', trans('app.genericError'));
        }
        
        $params['crumbs'] = '<a href="' . route('admin.dashboard') . '">' . trans('app.home') . '</a> >> ' . trans('app.accessControl') . ' >> <a href="' . route('admin.users.index') . '">' . trans('app.users') . '</a> >>' . trans('app.addNew');
        $params['active'] = 'access-control';
        
        return view('admin.users.create', $params);
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
            $params['entry'] = $this->user->find($id);
            $params['roles'] = $this->role->all()->get();
        } 

        catch (Exception $e) {
            return redirect(route('admin.dashboard'))->with('msgType', trans('app.msgTypeError'))->with('msg', trans('app.genericError'));
        }
        
        $params['crumbs'] = '<a href="' . route('admin.dashboard') . '">' . trans('app.home') . '</a> >> ' . trans('app.accessControl') . ' >> <a href="' . route('admin.users.index') . '">' . trans('app.users') . '</a> >>' . trans('app.edit');
        $params['active'] = 'access-control';
        
        return view('admin.users.edit', $params);
    }

    /**
     * Save entry
     *
     * @return Response
     */
    public function store()
    {
        try {
            $user = $this->user->store(Input::all());
            
            // set user roles
            if (Input::get('id') != Auth()->user()->id && Auth()->user()->can([
                'manage-roles'
            ])) {
                $this->role->assignRolesToUser($user, Input::get('role_id'));
            }
        } 

        catch (NotFoundException $e) {
            return $this->ajaxErrors($e->getErrors(), trans('app.genericError'));
        } 

        catch (ValidationException $e) {
            return $this->ajaxErrors($e->getErrors(), trans('app.correctErrors'));
        } 

        catch (Exception $e) {
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
            $this->user->delete($id);
            
            return $this->ajaxSuccess(trans('app.genericSuccess'), [
                'redirect' => route('admin.users.index')
            ]);
        } 

        catch (SaveException $e) {
            return $this->ajaxError($e->getMessage());
        } 

        catch (Exception $e) {
            return $this->ajaxError(trans('app.genericError'));
        }
    }
}
