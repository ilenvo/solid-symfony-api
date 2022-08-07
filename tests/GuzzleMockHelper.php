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

namespace App\Tests;

use GuzzleHttp\Handler\MockHandler as DefaultMockHandler;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Class GuzzleMockHelper
 * @package App\Tests
 */
class GuzzleMockHelper
{
    private static DefaultMockHandler $mockHandler;

    public function __invoke(RequestInterface $request, array $options): PromiseInterface
    {
        return static::getMockHandler()($request, $options);
    }

    private static function getMockHandler(): DefaultMockHandler
    {
        if (!isset(static::$mockHandler)) {
            static::$mockHandler = new DefaultMockHandler();
        }
        return static::$mockHandler;
    }

    public static function queue(...$values): void
    {
        static::getMockHandler()->reset();
        static::getMockHandler()->append(...$values);
    }

    public static function countQueue(): int
    {
        return count(static::getMockHandler());
    }
}
