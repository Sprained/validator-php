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
        if(!preg_match('@[A-Z]@', $pass)) {
            $this->error("Senha deve conter no minimo uma letra maiúscula!");
        } else if(!preg_match('@[a-z]@', $pass)) {
            $this->error("Senha deve conter no minimo uma letra minúscula!");
        } else if(!preg_match('@[0-9]@', $pass)) {
            $this->error("Senha deve conter letras e números!");
        } else if(!preg_match('@[^\w]@', $pass)) {
            $this->error("Senha deve conter no minimo caractere especial!");
        } else if($this->required($pass, 'Senha')) {
            return base64_encode(hash_hmac('sha256', $this->count(6, null,  "Senha", $pass), KEY, true));
        }
    }

    public function confirm_password($pas, $confirm_pass) {
        if($pas !== $confirm_pass) {
            $this->error("Senhas devem ser iguais!");
        }
    }

    public function compare_cript_password($pass, $cript_pass)
    {
        if(base64_encode(hash_hmac('sha256', $pass, KEY, true)) !== $cript_pass) {
            return false;
        } else {
            return true;
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

    public function cep($cep)
    {
        if($this->count(8, 8, 'CEP', preg_replace('/[^0-9]/', null, $cep))) {
            return preg_replace('/[^0-9]/', null, $cep);
        }
    }
}