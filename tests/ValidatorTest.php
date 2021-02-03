<?php

namespace Sprained;

use PHPUnit\Framework\TestCase;
use Sprained\Validator;

class ValidatorTest extends TestCase //comentar o die() na função de erro para fazer os teste
{
    public function testRequired()
    {
        $validator = new Validator();

        //Retorno required
        $this->assertEquals('Test', $validator->required('Test', 'Campo'));
        $this->assertEquals(['Test'], $validator->required(['Test'], 'Array'));

        $validator = new Validator();

        //Retorno erro tipo string
        $validator->required([''], 'Array');
        $this->assertEquals(400, http_response_code());
        $this->expectOutputString(json_encode(['message' => 'O campo Array é obrigatório!']));
    }

    public function testCount()
    {
        $validator = new Validator();

        //Retornos corretos
        $this->assertEquals('12', $validator->count(2, null, 'Campo', '12')); //min
        $this->assertEquals('12', $validator->count(null, 2, 'Campo', '12')); //max

        //Retorno erro minimo
        $validator->count(2, null, 'Campo', '1');
        $this->assertEquals(400, http_response_code());
        $this->expectOutputString(json_encode(['message' => 'O campo Campo deve conter, no mínimo, 2 caracteres!']));
    }

    public function testErrorMaxCount()
    {
        $validator = new Validator();

        //Retorno erro maximo
        $validator->count(null, 2, 'Campo', '123');
        $this->assertEquals(400, http_response_code());
        $this->expectOutputString(json_encode(['message' => 'O campo Campo deve conter, no máximo, 2 caracteres!']));
    }

    public function testPass()
    {
        $validator = new Validator();

        //Teste criptografia senha md5
        $this->assertEquals(md5('pass'), $validator->password('pass'));
    }

    public function testEmail()
    {
        $validator = new Validator();

        //Teste email valido
        $this->assertEquals('teste@email.com', $validator->email('teste@email.com'));

        //Teste email invalido
        $validator->email('testeemail.com');
        $this->assertEquals(400, http_response_code());
        $this->expectOutputString(json_encode(['message' => 'Email informado invalido!']));
    }

    public function testNum()
    {
        $validator = new Validator();

        //Teste email valido
        $this->assertEquals('1234', $validator->num('1234', 'Num'));

        //Teste email invalido
        $validator->num('1234Num', 'Num');
        $this->assertEquals(400, http_response_code());
        $this->expectOutputString(json_encode(['message' => 'O campo Num deve conter apenas números!']));
    }
}