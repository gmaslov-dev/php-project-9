<?php

namespace Hexlet\Code\Validator;

use Valitron\Validator;

class UrlValidator
{
    public static function validate(array $url): array|bool
    {
        $v = new Validator($url);
        $v->rule('required', 'name')->message('URL не должен быть пустым');
        $v->rule('lengthMax', 'name', 255)->message('Максимальная длина — 255 символов');
        $v->rule('url', 'name')->message('Некорректный URL');

        $v->validate();
        return $v->errors();
    }
}
