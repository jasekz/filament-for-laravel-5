<?php

namespace App\Http\Controllers\Admin;

class AdminController extends \App\Http\Controllers\Controller {
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }
}
