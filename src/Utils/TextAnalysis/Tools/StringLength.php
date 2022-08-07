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

namespace App\Utils\TextAnalysis\Tools;

class StringLength implements ToolsInterface
{
    public function getResult(string $text): int
    {
        return mb_strlen($text);
    }
}
