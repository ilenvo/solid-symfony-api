<?php

declare(strict_types=1);

/**
 * This project shows, how you can build a SOLID and restful API with symfony.
 *
 * @copyright  Stefan H.G. Buchhofer
 * @link       www.ilenvo.com
 * @email      ilenvo@me.com
 * @year       2022
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ControllerTestCase extends WebTestCase
{
    protected ?KernelBrowser $client = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
    }

    protected static function assertJsonContainsArray(array $contains, string $actual): void
    {
        $structure = json_decode($actual, true, 512, JSON_THROW_ON_ERROR);
        $common = array_replace_recursive($structure, $contains);
        self::assertEquals($common, $structure);
    }

    protected function httpJsonHeader(): array
    {
        return ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'];
    }
}
