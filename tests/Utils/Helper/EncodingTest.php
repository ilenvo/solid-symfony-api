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

namespace App\Tests\Utils\Helper;

use App\Utils\Helper\Encoding;
use PHPUnit\Framework\TestCase;

class EncodingTest extends TestCase
{
    public function testMustEncode(): void
    {
        $utf8 = 'äüöß';
        $iso88591_1 = iconv('UTF-8', 'ISO-8859-1', $utf8);

        $encoding = new Encoding();
        $result = $encoding->fixEncoding($iso88591_1);
        self::assertSame($utf8, $result);
    }

    public function testNoEncode(): void
    {
        $utf8 = 'äüöß';
        $encoding = new Encoding();
        $result = $encoding->fixEncoding($utf8);
        self::assertSame($utf8, $result);
    }
}
