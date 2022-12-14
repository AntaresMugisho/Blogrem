<?php
namespace App;
use Valitron\Validator as Val;

    
class Validator extends Val{


     /**
     * @param  string $field
     * @param  string $message
     * @param  array  $params
     * @return array
     */
    protected function checkAndSetLabel($field, $message, $params)
    {
        if (isset($this->_labels[$field])) {
            $message = str_replace('{field}', $this->_labels[$field], $message);

            if (is_array($params)) {
                $i = 1;
                foreach ($params as $k => $v) {
                    $tag = '{field' . $i . '}';
                    $label = isset($params[$k]) && (is_numeric($params[$k]) || is_string($params[$k])) && isset($this->_labels[$params[$k]]) ? $this->_labels[$params[$k]] : $tag;
                    $message = str_replace($tag, $label, $message);
                    $i++;
                }
            }
        } else {
            $message = $this->prepend_labels
                ? str_replace('{field}', ucwords(str_replace('_', ' ', $field)), $message)
                : str_replace('{field} ', '', $message);
        }

        return $message;
    }
}
?>

