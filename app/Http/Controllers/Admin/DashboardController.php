<?php

namespace App\Http\Controllers\Admin;

use Auth;

class DashboardController extends AdminController {


    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {        
        $params['crumbs'] = 'Home';
        $params['active'] = 'home';
        
        return view('admin.dashboard.index', $params);
    }
}
