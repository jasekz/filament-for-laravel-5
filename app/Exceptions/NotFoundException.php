<?php namespace App\Exceptions;

use App\Exceptions\BaseException;

class NotFoundException extends BaseException {

    /**
     * Constructor
     * 
     * @param array $errors
     * @param string $error
     */    
    public function __construct($error = 'Entry not found.', $errors = [])
    {
        parent::__construct($error, $errors);
    }

}
