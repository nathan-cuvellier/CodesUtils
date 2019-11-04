<?php

/**
 * User: Nathan Cuvellier
 * Date: 01/04/17
 */
class DataBase {

    /** @var PDO  */
    private $pdo;

    /**
     * DataBase constructor.
     *
     * @param String $host
     * @param String $name
     * @param String $user
     * @param String $password
     */
    public function __construct(String $name, String $user, String $password, String $host = "localhost") {
        try {
            $this->pdo = new PDO("mysql:dbname=$name;host=$host;charset=UTF8", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch(PDOException $error) {
            die("Erreur lors de la connexion à la base de donnée merci de contacter <nathan@revision.fr> ");
        }
    }

    public function query(String $statement, array $params = null) {
        if($params != null) {
            $req = $this->pdo->prepare($statement)->execute($params);
        } else {
            $req = $this->pdo->query($statement);
        }
        return $req;
    }

}
