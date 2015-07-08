<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Response;
use Session;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Return ajax errors
     *
     * @param
     *            Response
     */
    protected function ajaxErrors($errors = [], $msg = null)
    {
        return Response::json([
            'msg' => $msg ? $msg : trans('app.genericError'),
            'error' => true,
            'errors' => $errors
        ]);
    }

    /**
     * Return ajax error message
     *
     * @param Response
     */
    protected function ajaxError($msg = 'Error')
    {
        return Response::json([
            'msg' => $msg,
            'error' => true
        ]);
    }

    /**
     * Return ajax success message
     *
     * @param Response
     */
    protected function ajaxSuccess($msg = 'Success', $data = array())
    {
        Session::flash('msgType', trans('app.msgTypeSuccess'));
        Session::flash('msg', $msg);
        
        $response = [
            'error' => false,
            'msg' => trans('app.genericSuccess'),
        ];
        
        $response += $data;
        
        return Response::json(array_merge($data, $response));
    }
}
