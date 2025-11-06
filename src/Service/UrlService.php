<?php

namespace Hexlet\Code\Service;

readonly class UrlService
{
    public static function getBaseUrl(string $url): string
    {
        $parts = parse_url($url);

        if (!$parts || !isset($parts['scheme']) || !isset($parts['host'])) {
            return '';
        }
        return $parts['scheme'] . '://' . $parts['host'];
    }
}
