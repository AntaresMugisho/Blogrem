<?php

namespace App\Helpers;

class ObjectHelper {

    public static function hydrate($object, $data, array $fields)
    {   
        foreach($fields as $field){
            $setter = "set_" . $field;
            $object->$setter($data[$field]);
        }
    }
}

?>