<?php namespace App\Exceptions;

use Exception;

class BaseException extends Exception {
    
    /**
     * List of errors
     * 
     * @var array
     */
    protected  $errors;

    /**
     * Constructor
     * 
     * @param array $errors
     * @param string $error
     */
    public function __construct($error = 'Error', $errors = []) 
    {
        $this->errors = $errors;
        parent::__construct($error);
    }
    
    /**
     * Return all errors
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    public function getErrorsAsString()
    {
        $msg = 'Please correct the following errors:<br>';
        $flatArr = [];
        if($this->errors) {
            foreach($this->errors as $errors) {
                foreach($errors as $error) {
                    $flatArr[] = $error;
                }
            }
        }
        
        if($flatArr) {
            $msg .= implode('<br>', $flatArr);
        }
        
        return $msg;
    }

}
