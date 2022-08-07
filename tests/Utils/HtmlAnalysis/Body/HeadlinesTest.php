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

use App\Utils\Helper\Encoding;
use App\Utils\HtmlAnalysis\Body\Headlines;
use PHPUnit\Framework\TestCase;

class HeadlinesTest extends TestCase
{
    public function testParserNoHeadlines(): void
    {
        $headlines = new Headlines(new Encoding());
        $rawString = 'no headlines at all';

        $result = $headlines->getHeadlines($rawString);
        self::assertSame(
            [
                'h1' => ['count' => 0, 'results' => []],
                'h2' => ['count' => 0, 'results' => []],
                'h3' => ['count' => 0, 'results' => []],
                'h4' => ['count' => 0, 'results' => []],
                'h5' => ['count' => 0, 'results' => []],
            ],
            $result
        );
    }

    public function testSomeHeadlines(): void
    {
        $headlines = new Headlines(new Encoding());
        $rawString = '<h1>Alan Turing</h1>';

        $result = $headlines->getHeadlines($rawString);
        self::assertSame(
            [
                'h1' => ['count' => 1, 'results' => ['Alan Turing']],
                'h2' => ['count' => 0, 'results' => []],
                'h3' => ['count' => 0, 'results' => []],
                'h4' => ['count' => 0, 'results' => []],
                'h5' => ['count' => 0, 'results' => []],
            ],
            $result
        );
    }
}
