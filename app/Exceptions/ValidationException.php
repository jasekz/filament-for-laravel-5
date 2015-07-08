<?php namespace App\Exceptions;

use App\Exceptions\BaseException;

class ValidationException extends BaseException {

    /**
     * Constructor
     * 
     * @param array $errors
     * @param string $error
     */    
    public function __construct($error = 'Validation errors.', $errors = [])
    {
        parent::__construct($error, $errors);
    }
}
