<?php

/**
 * User: Nathan Cuvellier
 * Date: 01/04/17
 */
class DataBase {

    /**
     * DataBase constructor.
     *
     * @param $host
     * @param $name
     * @param $user
     * @param $password
     */
    public function __construct($name, $user, $password, $host = "localhost") {
        try {
            $this->pdo = new PDO("mysql:dbname=$name;host=$host;charset=UTF8", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch(PDOException $error) {
            die("Erreur lors de la connexion à la base de donnée merci de contacter <contact@exemple.com> ");
        }
    }
    
    /**
     * Function query
     *
     * @param $statement
     * @param $params = false
     */
    public function query(String $statement, $params = false) {
        if($params != false) {
            $req = $this->pdo->prepare($statement)->execute($params);
        } else {
            $req = $this->pdo->prepare($statement);
        }
        return $req;
    }

}
