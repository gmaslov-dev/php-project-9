<?php

namespace Hexlet\Code\Tests\Functional;

use Hexlet\Code\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class MainPageTest extends TestCase
{
    // Существование маршрута и возврат 200
    public function testMainPageRouteExists(): void
    {
        $response = $this->createRequest('GET', '/');
        $this->assertEquals(200, $response->getStatusCode());
    }

    // Возвращается HTML
    public function testMainPageReturnsHtml(): void
    {
        $response = $this->createRequest('GET', '/');
        $this->assertStringContainsString(
            'text/html',
            $response->getHeaderLine('Content-type')
        );
    }

    // HTML содержит форму и кнопку отправки
    #[DataProvider('elementProvider')]
    public function testMainPageContainsExpectedElements(string $needle, string $message): void
    {
        $response = $this->createRequest('GET', '/');
        $body = (string) $response->getBody();

        $this->assertTrue(str_contains($body, $needle), $message);
    }

    public static function elementProvider(): array
    {
        return [
            ['<input type="text">', 'Input not found'],
            ['<button type="submit">Submit</button>', 'Button not found'],
        ];
    }
}
