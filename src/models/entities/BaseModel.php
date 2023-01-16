<?php

namespace App\models\entities;


abstract class BaseModel
{
    protected array $rules = []; 
    protected array $errors = [];

    public function __construct($rules){
        $this->rules = $rules;
    }

    public function isValide()
    {
        $this->errors = [];

        foreach($this->rules as $field => $rules){
            foreach($rules as $key => $value){
                switch ($key) {
                    case 'required':
                        $this->mountError(
                            $this->checkRequire($field),
                            $field . ' est requis',
                            $field
                        );
                        break;

                    case 'unique':
                        $this->mountError(
                            $this->checkUnique($field),
                            $field . ' existe deja',
                            $field
                        );
                        break;

                    case 'min':
                        $this->mountError(
                            $this->checkMin($field, $value),
                            $field . ' doit avoir un minimum de ' . $value . ' caractères',
                            $field
                        );
                        break;

                    case 'max':
                        $this->mountError(
                            $this->checkMax($field, $value),
                            $field . ' doit avoir un maximum de ' . $value . ' caractères',
                            $field
                        );
                        break;  
                        
                    case 'match':
                        $this->mountError(
                            $this->checkMatch($field, $value),
                            $field . ' doit être similaire à ' . $value,
                            $field
                        );
                        break;  
                }
            }
        }

        return $this->errors;
    }

    private function mountError($condition, $error, $field)
    {
        if(!$condition) {
            if(!$this->errors[$field]) $this->errors[$field] = [];
            array_push($this->errors[$field], $error);
        }
    }


    // true si valide, false si invalide
    private function checkRequire($field)
    {
        return !empty($this->$field);
    }


    // true si unique, false si exsite deja
    private function checkUnique($field)
    {
        global $app;

        $query = "SELECT COUNT(*) FROM User WHERE $field = :attribute";
        $args = [
            ":attribute" => $this->username
        ];

        $statement = $app->database->exec($query, $args);
        $response = (int)$statement->fetchColumn();
        
        return $response === 0 ? true : false;
    }


     // true si valide, false si invalide
    private function checkMin($field, $value)
    {
        return strlen($this->$field) < $value ? false : true;
    }


    // true si valide, false si invalide
    private function checkMax($field, $value)
    {
        return strlen($this->$field) > $value ? false : true;
    }


    // true si valide, false si invalide
    private function checkMatch($field, $value)
    {
        return $this->$field !== $this->$value ? false : true;
    }
}