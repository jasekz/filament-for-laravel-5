<?php namespace App\Exceptions;

use App\Exceptions\ValidationException;

class InvalidFileException extends ValidationException {

    /**
     * Constructor
     * 
     * @param array $errors
     * @param string $error
     */    
    public function __construct($error = 'Invalid file.', $errors = [])
    {
        parent::__construct($error, $errors);
    }

}
