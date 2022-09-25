<?php

namespace App\Validators;
use App\Validator;

abstract class AbstractValidator{

        
    protected $data;
    protected $validator;

    public function __construct(array $data)    
    {
        Validator::lang("fr");
        
        $this->data = $data;
        $this->validator = new Validator($this->data);

    }

    public function validate(): bool
    {
        return $this->validator->validate();
    }

    public function errors(): array
    {
        return $this->validator->errors();
    }

}

?>