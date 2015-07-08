<?php
namespace App\Models;

use Validator;

trait BaseModelTrait {

    /**
     * Validation for all models
     * 
     * @param array $data
     * @return boolean
     */
    public function validate($data = [])
    {
        $data = $data ? $data : $this->getAttributes();
        $v = Validator::make($data, $this->rules, $this->messages);

        if ($v->fails()) {
            $this->errors = $v->errors();
            return false;
        }
        
        return true;
    }

    /**
     * Return errors
     * 
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }
    
    /**
     * Rules accessor
     * 
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Remove validation rule
     * 
     * @param string $key
     */
    public function removeRule($key)
    {
        unset($this->rules[$key]);
    }
    
    /**
     * Add validation rule
     * 
     * @param string $key
     * @param string $value
     */
    public function addRule($key, $value)
    {
        $this->rules[$key] = $value;
    }
}