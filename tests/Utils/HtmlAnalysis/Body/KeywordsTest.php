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

namespace App\Tests\Utils\HtmlAnalysis\Body;

use App\Utils\Helper\CleanHtml;
use App\Utils\HtmlAnalysis\Body\Keywords;
use PHPUnit\Framework\TestCase;

class KeywordsTest extends TestCase
{
    public function testTopTenDe(): void
    {
        $keywords = new Keywords(new CleanHtml());
        $rawHtml = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'mock' . DIRECTORY_SEPARATOR . 'ilenvo.html');

        $topFiveResult = $keywords->getTopTen($rawHtml);

        self::assertEquals(
            [
                'software' => 5,
                'development' => 4,
                'jahren' => 3,
                'kontakt' => 2,
                'entwickler' => 2,
                'ausbildung' => 2,
                'ilenvo' => 2,
                'media' => 2,
                'arbeit' => 2,
                'apps' => 2
            ],
            $topFiveResult
        );
    }

    public function testTopTenEn(): void
    {
        $keywords = new Keywords(new CleanHtml());
        $rawHtml = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'mock' . DIRECTORY_SEPARATOR . 'ilenvo-en.html');

        $topFiveResult = $keywords->getTopTen($rawHtml);

        self::assertEquals(
            [
                'software' => 5,
                'development' => 4,
                'years' => 4,
                'first' => 3,
                'programming' => 3,
                'consulting' => 2,
                'contact' => 2,
                'developer' => 2,
                'computer' => 2,
                'after' => 2
            ],
            $topFiveResult
        );
    }

    public function testTopTenNoBody(): void
    {
        $keywords = new Keywords(new CleanHtml());
        $rawHtml = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'mock' . DIRECTORY_SEPARATOR . 'no-body.html');

        $topFiveResult = $keywords->getTopTen($rawHtml);

        self::assertEquals([], $topFiveResult);
    }
}
