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

namespace App\Utils\HtmlAnalysis\Common;

class Javascript
{
    public function getAll(string $rawHtml): array
    {
        preg_match_all("/<\s*script\s+[^>]*src\s*=\s*[\"']?([^\"' >]+)[\"' >]/", $rawHtml, $scripts);
        return $scripts ?? [];
    }
}
