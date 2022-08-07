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

namespace App\Utils\HtmlAnalysis\Head;

class Metas
{
    public function getTitle(string $rawHtml): ?string
    {
        preg_match_all("/(?<=(?i)\<title\>).*?(?=(?i)\<\/title\>)/", $rawHtml, $titles);
        return $titles[0][0] ?? null;
    }

    public function getDescription(string $rawHtml): ?string
    {
        preg_match_all(
            "/<meta[^>]*name=[\"|\']description[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i",
            $rawHtml,
            $descriptions
        );
        return $descriptions[1][0] ?? null;
    }

    public function getKeywords(string $rawHtml): ?string
    {
        preg_match_all(
            "/<meta[^>]*name=[\"|\']keywords[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i",
            $rawHtml,
            $keywords
        );
        return $keywords[1][0] ?? null;
    }

    public function getEncoding(string $rawHtml): ?string
    {
        preg_match_all("/<meta.*?charset=([^\"']+)/i", $rawHtml, $encodings);
        return $encodings[1][0] ?? null;
    }

    public function getGenerator(string $rawHtml): ?string
    {
        preg_match_all(
            "/<meta[^>]*name=[\"|\']generator[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i",
            $rawHtml,
            $generators
        );

        return $generators[1][0] ?? null;
    }

    public function getRobots(string $rawHtml): ?string
    {
        preg_match_all("/<meta[^>]*name=[\"|\']robots[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i", $rawHtml, $robots);
        return $robots[1][0] ?? null;
    }


    public function getContentLanguage(string $rawHtml): ?string
    {
        preg_match_all(
            "/<meta[^>]*name=[\"|\']content-language[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i",
            $rawHtml,
            $contentLanguages
        );
        return $contentLanguages[1][0] ?? null;
    }

    public function getLanguage(string $rawHtml): ?string
    {
        preg_match_all(
            "/<meta[^>]*name=[\"|\']language[\"|\'][^>]*content=[\"]([^\"]*)[\"][^>]*>/i",
            $rawHtml,
            $languages
        );
        return $languages[1][0] ?? null;
    }
}
