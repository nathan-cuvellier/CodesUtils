<?php

/**
* require 'Autoload.php';
* new Autoload();
*/
class Autoload {

    /**
     * Autoload constructor.
     */
    public function __construct() {
        self::register();
    }

    /**
     * Use a array if the autolaod is in a class
     * @return void
     */
    function register() {
        spl_autoload_register([__CLASS__, 'my_autoload']);
    }

    /**
     * @param $class
     *
     * @return void
     */
    function my_autoload($class) {
        $path = __DIR__ . DIRECTORY_SEPARATOR;
        if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . "$class.php")) {
            require_once $path . "$class.php";
        }
    }

}
