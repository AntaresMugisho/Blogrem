<?php

namespace App\Helpers;

class Text {


    public static function excerpt(string $content, int $limit = 65):string
    {

        if (mb_strlen($content) <= $limit){
            return $content;
        }

        $last_space = mb_strpos($content, " ", $limit);

        return mb_substr($content, 0, $last_space) . " ...";
    }
}

?>