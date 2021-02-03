<?php

namespace Sprained;

class Validator
{
    private function error($erro)
    {
        http_response_code(400);
        echo json_encode(['message' => $erro]);
        die;
    }

    public function required($char, $campo)
    {
        if(is_array($char)){
            if(!array_filter(array_map('trim', $char))) {
                $this->error("O campo $campo é obrigatório!");
            }

            return array_map('trim', $char);
        } else {
            if(!trim($char)){
                $this->error("O campo $campo é obrigatório!");
            }

            return trim($char);
        }
    }

    public function count($min, $max, $campo, $char)
    {
        if($this->required($char, $campo)){
            if ($min && strlen(trim($char)) < $min) {
                $this->error("O campo $campo deve conter, no mínimo, $min caracteres!");
            } else if ($max && strlen(trim($char)) > $max) {
                $this->error("O campo $campo deve conter, no máximo, $max caracteres!");
            }

            return trim($char);
        }
    }

    public function password($pass)
    {
        if($this->required($pass, 'Senha')) {
            return md5($this->count(6, null,  "Senha", $pass));
        }
    }

    public function email($email)
    {
        if($this->required($email, 'Email')){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error('Email informado invalido!');
            }
    
            return $email;
        }
        
    }

    public function num($char, $campo)
    {
        if($this->required($char, $campo)){
            if (!is_numeric($char)) {
                $this->error("O campo $campo deve conter apenas números!");
            }
        }
        
        return trim($char);
    }
}