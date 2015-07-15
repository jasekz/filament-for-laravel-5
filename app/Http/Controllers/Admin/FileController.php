<?php

namespace App\Http\Controllers\Admin;

use OAuth\OAuth2\Service\Google;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;

use App\Services\File;

use Exception;
use Input;

class FileController extends AdminController {
    
    /**
     * Constructor
     * 
     * @param File $file
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $files = $this->file->all()->get();
                
	    return response()->json(['status' => 'success', 'data' => $files]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{	  
        try {
            $file = $this->file->store('test-storage');
        } 

        catch (Exception $e) {
            return response()->json(['status' => 'error', 'data' => $e->getMessage()]);
        }
        
        return response()->json(['status' => 'success', 'url' => $file->file, 'thumbId' => Input::get('thumbId')]);
	}
	
	public function destroy($id)
	{ 	  
        try {
            $fileName = $this->file->delete($id);
        } 

        catch (Exception $e) {
            return response()->json(['status' => 'error', 'data' => $e->getMessage()]);
        }
        
        return response()->json(['status' => 'success']);
	}
}
