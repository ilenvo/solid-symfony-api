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

namespace App\Utils\Helper;

class Encoding
{
    public function fixEncoding(string $string): string
    {
        if (mb_detect_encoding($string, 'UTF-8', true)) {
            return $string;
        }
        return utf8_encode($string);
    }
}
