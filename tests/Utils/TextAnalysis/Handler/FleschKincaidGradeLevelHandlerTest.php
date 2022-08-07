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

namespace App\Tests\Utils\TextAnalysis\Handler;

use App\Utils\TextAnalysis\DTO\Factory;
use App\Utils\TextAnalysis\Handler\FleschKincaidGradeLevelHandler;
use PHPUnit\Framework\TestCase;

class FleschKincaidGradeLevelHandlerTest extends TestCase
{
    public function testAnalyzeString(): void
    {
        $factory = new Factory();
        $handler = new FleschKincaidGradeLevelHandler($factory);
        $result = $handler->analyzeString('This is a very easy sentence.');

        self::assertSame('FleschKincaidGradeLevel', $result->getName());
        self::assertSame('4.50', $result->getValue());
    }
}
