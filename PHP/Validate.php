<?php

/**
 * Author: Nathan Cuvellier
 * Create : 2017-03-26
 */
class Validate {

    private $data;
    private $errors = [];

    /**
     * Validate constructor.
     *
     * @param $data
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * @param String $field
     *
     * @return null or data
     */
    public function getField(String $field) {
        if(isset($this->data[$field])) {
            return $this->data[$field];
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isValid(): bool {
        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors(): array {
        return $this->errors;
    }

    /**
     * Verify if has error in particular
     * It's useful for not checking if there is already one on the same field
     * Example:
     * $valid->isEMail('mail', 'It's bad format');
     * if(!$valid->hasError('mail')){ // Only if no yet error
     *      $valid->isUnique('mail', 'This email is already used');
     * }
     *
     * @param String $field
     *
     * @return bool
     */
    public function hasError(String $field): bool {
        return array_key_exists($field, $this->errors);
    }

    /**
     * Check if $field is NULL
     * default value is TRUE
     *
     * @param String $field
     *
     * @return bool
     */
    public function isNULL(String $field): bool {
        if(!isset($this->data[$field]) || !trim($this->data[$field])) {
            return false;
        }
        return true;
    }

    /**
     * @param String $field
     *
     * @return bool
     */
    public function isButtonCheck(String $field): bool {
        if(isset($_POST[$field])) {
            return true;
        }
        return false;
    }

    /**
     * @param String $field
     * @param $error
     */
    public function isEMail(String $field, String $error) {
        if(!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $error;
        }
    }

    /**
     * Check if $field is a URL with function preg_match
     * check if has http or https etc ↓
     * FILTER_VAR_URL is not enough precis
     *
     * @param String $field
     * @param String $error
     */
    public function isURL(String $field, String $error) {
        if(isset($this->data[$field]) && !preg_match('/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $this->getField($field))) {
            $this->errors[$field] = $error;
        }
    }

    /**
     * In a first time, check if data is NULL
     * In a second time, check if data error (FILE) is not equal at 0
     * In a third time, check if file type of is not PNG | JPEG | JPG
     * In a fourth time, check if file size is too big
     * The file unit is megabyte (default bytes), so to convert bytes to megabyte => divide per 1 000 000
     *
     * @param String $field
     * @param String $error
     * @param int $MaxSize => default value =  2Mo
     */
    public function isCorrectPicture(String $field, String $error, int $MaxSize = 2) {
        //Check if data is null
        if($this->isNULL($this->data[$field])) {
            $this->errors[$field] = $error;
            return;
        }
        //Check if data has error
        if($_FILES[$field]['error'] != 0) {
            $this->errors[$field] = $error;
            return;
        }
        //Check extension of picture
        if($_FILES[$field]['type'] != "image/png" || $_FILES[$field]['type'] != "image/jpeg" || $_FILES[$field]['type'] != "image/jpg") {
            $this->errors[$field] = $error;
            return;
        }
        //Check size of picture
        if($_FILES[$field]['size'] / 1000000 > $MaxSize) {
            $this->errors[$field] = $error;
            return;
        }

    }

    /**
     * @param String $field
     * @param int $minLength
     * @param String $error
     */
    public function isTooShort(String $field, int $minLength, String $error) {
        if(strlen($this->getField($field)) < $minLength) {
            $this->errors[$field] = $error;
        }
    }

    /**
     * @param String $field
     * @param int $maxLength
     * @param String $error
     */
    public function isTooLong(String $field, int $maxLength, String $error) {
        if(strlen($this->getField($field)) > $maxLength) {
            $this->errors[$field] = $error;
        }
    }

    /**
     * @param String $field
     * @param $db ==> Connection at DataBase par variable to avoid use a require
     * @param String $table /!\ The name of table must be that $field
     * @param String $error
     */
    public function isUnique(String $field,$db, String $table, String $error){
        $req = $db->query("SELECT $field FROM $table WHERE $field = ?", $this->getField($field));
        if($req){
            $this->errors[$field] = $error;
        }
    }
}