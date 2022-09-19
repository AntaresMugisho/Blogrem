<?php

namespace App\HTML;

class Form{

    private $data;
    private $errors;

    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    public function input(string $key, string $label)
    {
        $value = $this->get_value($key);

        $html = <<<HTML
            <div class="form-group">
                <label for={$key}>$label</label>
                <input type="text" name={$key} id={$key} class="form-control my-2 {$this->get_invalid_class($key)}" value={$value}>
                {$this->get_invalid_feedback($key)}
            </div>
        HTML;

        return $html;
    }

    public function textarea(string $key, string $label)
    {
        $value = $this->get_value($key);

        $html = <<<HTML
            <div class="form-group">
                <label for=$key>$label</label>
                <textarea type="text" name=$key id=$key class="form-control my-2 {$this->get_invalid_class($key)}">$value</textarea>
                {$this->get_invalid_feedback($key)}
            </div>
        HTML;

        return $html;
    }

    private function get_value($key)
    {
        if (is_array($this->data)){
            return $this->data[$key];
        }

        $getter = "get_" . $key;
        $value = $this->data->$getter();

        if ($value instanceof \DateTimeInterface){
            return $value->format("Y-m-d H:i:s");
        }

        return $value;
    }

    private function get_invalid_class($key):string
    {
        $invalid_class = "";
        if (isset($this->errors[$key])){
            $invalid_class .= "is-invalid";
        }

        return $invalid_class;
    } 

    private function get_invalid_feedback($key):string
    {
        $invalid_feedback = "";
        if (isset($this->errors[$key])){
            $invalid_feedback .= "<small class='invalid-feedback'>" . implode('<br>', $this->errors[$key]) . "</small><br>";
        }
        return $invalid_feedback;
    }   

}



?>
