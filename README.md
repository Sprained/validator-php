# Validação PHP

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

Biblioteca para a realização de validações de dados no desenvolvimento PHP, com o objetivo de facilitar o desenvolvimento e proporcionar uma maior verificação de dados.

## Funcionalidades

- [Validações](#validações)

## Instalação

Via Composer

``` bash
$ composer require sprained/validator-php
```

## Uso

### Validações

Após a chamada de função, caso o dado passado seja válido, a mesma retornará o valor lhe fornecido para análise, se não, retornará um JSON de erro.

``` php
require 'vendor/autoload.php';

use Sprained\Validator;

$validator = new Validator();

/*
    Campo obrigatório: verifica se o valor preenchido está vazio (preenchido apenas com espaços ou não preenchido)
    Primeiro parâmetro: valor a ser analisado (Array ou String)
    Segundo parâmetro: nome do campo do valor informado
*/
$required = $validator->required($_POST['required'], 'Required');

/*
    Contagem: verifica o tamanho mínimo e máximo de caracteres de um campo
    Primeiro parâmetro: mínimo de caracteres (Valor ou Null para casos onde não há valor mínimo)
    Segundo parâmetro: máximo de caracteres (Valor ou Null para casos onde não há valor mínimo)
    Terceiro parâmetro: nome do campo do valor informado
    Quarto parâmetro: valor a ser analisado
*/
$count = $validator->count('10', '10', 'Count', $_POST['count']);

/*
    Password: verifica se o valor preenchido está vazio, caso não, será retornado o valor informado criptografado em md5
    Primeiro parâmetro: valor a ser analisado
*/
$password = $validator->password($_POST['password']);

/*
    Email: verifica se o valor informado tem o formato padrão de e-mail
    Primeiro parâmetro: valor a ser analisado
*/
$email = $validator->email($_POST['email']);

/*
    Num: verifica se o valor preenchido há caracteres, devendo ser apenas números
    Primeiro parâmetro: valor a ser analisado
    Segundo parâmetro: nome do campo do valor informado
*/
$num = $validator->num($_POST['num'], 'Num');

/*
    Cep: verifica se o valor preenchido segue padrão CEP, e remove o hífen retornando apenas os números
    Primeiro parâmetro: valor a ser analisado
*/
$cep = $validator->cep($_POST['cep']);

/*

Resultado de erro:

A mensagem muda conforme o erro de validação!

{
    message: O campo Required é obrigatório!
}

*/
```

## Créditos

- [Gabriel Resende][link-author]
- [Vitoria Camila][link-vickie]

[ico-version]: https://img.shields.io/packagist/v/sprained/validator-php.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sprained/validator-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sprained/validator-php
[link-downloads]: https://packagist.org/packages/sprained/validator-php
[link-author]: https://github.com/sprained
[link-vickie]: https://github.com/itsvickie