<?php

namespace Hexlet\Code\Validator;

use Valitron\Validator;

class UrlValidator
{
    public static function validate($url)
    {
        $v = new Validator($url);
        $v->rules(['required' => ['name'],
            'lengthMax' => [['name', 255]],
            'url' => ['name']]);
        $v->validate();
        return $v->errors();
    }
}