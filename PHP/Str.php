<?php

/**
 * Author: Nathan Cuvellier
 * Create : 2017-03-26
 */
class Str {

    static function random($length){
        $alphanumeric = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr(str_shuffle(str_repeat($alphanumeric, $length)), 0, $length);
    }
}