<?php
namespace App\Http\Controllers\Admin;

use App\Services\Permission;
use App\Exceptions\ValidationException;
use App\Exceptions\NotFoundException;
use Auth;
use Config;
use Exception;
use Input;

class PermissionController extends AdminController {

    /**
     * Constructor
     *
     * @param App\Services\Permission $permission            
     */
    public function __construct(Permission $permission)
    {
        parent::__construct();
        
        $this->middleware('auth.admin:manage-permissions');
        
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
            $params['entries'] = $this->permission->all(Input::all())->paginate($show);
        } 

        catch (Exception $e) {
            return redirect(route('admin.dashboard'))->with('msgType', trans('app.msgTypeError'))->with('msg', trans('app.genericError'));
        }
        
        $params['crumbs'] = '<a href="' . route('admin.dashboard') . '">' . trans('app.home') . '</a> >> ' . trans('app.accessControl') . ' >> ' . trans('app.permissions');
        $params['active'] = 'permissions';
        
        return view('admin.permissions.index', $params);
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
            $params['entry'] = $this->permission->find($id);
        } 

        catch (Exception $e) {
            return redirect(route('admin.dashboard'))->with('msgType', trans('app.msgTypeError'))->with('msg', trans('app.genericError'));
        }
        
        $params['crumbs'] = '<a href="' . route('admin.dashboard') . '">' . trans('app.home') . '</a> >> ' . trans('app.accessControl') . ' >> <a href="' . route('admin.permissions.index') . '">' . trans('app.permissions') . '</a> >>' . trans('app.edit');
        $params['active'] = 'permissions';
        
        return view('admin.permissions.edit', $params);
    }

    /**
     * Save entry
     *
     * @return Response
     */
    public function store()
    {
        try {
            $res = $this->permission->store(Input::all());
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
}
