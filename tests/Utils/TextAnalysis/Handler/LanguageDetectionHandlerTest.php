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
use App\Utils\TextAnalysis\Handler\LanguageDetectionHandler;
use PHPUnit\Framework\TestCase;

class LanguageDetectionHandlerTest extends TestCase
{
    public function testAnalyzeString(): void
    {
        $factory = new Factory();
        $handler = new LanguageDetectionHandler($factory);

        $result = $handler->analyzeString(
            'This is only a dummy text. This has no meaning at all. But if you invite me i am happy to come. 
            We need more text to detect the english language correct.'
        );

        self::assertSame('LanguageDetection', $result->getName());
        self::assertSame('en', $result->getValue());
    }
}
