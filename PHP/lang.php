<?php

class lang {

	public static function setLang(){
        if(isset($_GET['lang'])) {
            if(file_exists("lang/{$_GET['lang']}.php")) {
                if($_GET['lang'] == "tr") {
                    require 'lang/fr.php';
                } else {
                    require "lang/{$_GET['lang']}.php";
                }
            } else {
                require 'lang/fr.php';
            }
        } else {
            /*
            * Include default lang
            */
            require 'lang/fr.php';
        }
    }

} 
