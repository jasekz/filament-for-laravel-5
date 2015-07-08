<?php

namespace App\Http\Controllers\Admin;

use App\Services\User;
use App\Exceptions\ValidationException;
use Exception;
use Auth;
use Input;

class MyAccountController extends AdminController {

    /**
     * Constructor
     *
     * @param App\Services\User $user            
     */
    public function __construct(User $user)
    {
        parent::__construct();        
        $this->user = $user;
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
            $params['entry'] = Auth()->user();
        } 

        catch (Exception $e) {
            return redirect(route('admin.dashboard'))->with('msgType', trans('app.msgTypeError'))->with('msg', trans('app.genericError'));
        }
        
        $params['crumbs'] = '<a href="' . route('admin.dashboard') . '">' . trans('app.home') . '</a> >> '. trans('app.myAccount') . ' >>' . trans('app.edit');
        $params['active'] = 'admin';
        
        return view('admin.myAccount.edit', $params);
    }

    /**
     * Save entry
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::all();
        
        // we only want to edit the currently logged in user
        $data['id'] = Auth()->user()->id;
        
        try {
            $user = $this->user->store($data);
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
}
