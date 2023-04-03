<?php

class Extension
{
    public static function Stringcontain($value, $searchIn){
        $isLocal = (strpos($searchIn, $value) !== false) ? true : false;
        return $isLocal;
    }

    public static function checkIfIsLastLoop($key, $array){
        $lastLoop = false;
        if(floatval(phpversion()) < 7.2)
            end($array);
            if ($key === key($array)) $lastLoop = true;
        else
            if ($key === array_key_last($array)) $lastLoop = true;
        return $lastLoop;
    }
}
?>