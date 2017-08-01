<?php

namespace brandonshar;

class Str
{
    public static function splitCamelCase($str)
    {
        return implode(' ', preg_split("/((?<=[a-z])(?=[A-Z])|(?=[A-Z][a-z]))/", $str));
    }
}