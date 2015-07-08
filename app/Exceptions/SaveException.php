<?php namespace App\Exceptions;

use App\Exceptions\ValidationException;

class SaveException extends BaseException {

    /**
     * Constructor
     * 
     * @param array $errors
     * @param string $error
     */    
    public function __construct($error = 'Could not save entry.', $errors = [])
    {
        parent::__construct($error, $errors);
    }

}
