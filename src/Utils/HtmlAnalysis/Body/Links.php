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

namespace App\Utils\HtmlAnalysis\Body;

class Links
{
    public function getAllLinks(string $rawHtml): array
    {
        $links = [];
        preg_match_all("/<\s*a\s+[^>]*href\s*=\s*[\"']?([^\"' >]+)[\"' >]/", $rawHtml, $links);
        return $links;
    }

    public function getInternalLinks(string $rawHtml, string $domainName): array
    {
        $internalLinks = [];
        $links = $this->getAllLinks($rawHtml);

        foreach ($links[1] as $link) {
            if (
                (stripos($link, $domainName) !== false || stripos($link, "://") === false) &&
                !str_contains($link, "javascript:") && !str_contains($link, "mailto:") && !str_contains($link, "#")
            ) {
                $internalLinks[$link] = $link;
            }
        }

        return $internalLinks;
    }

    public function getExternalLinks(string $rawHtml, string $domainName): array
    {
        $externalLinks = [];
        $links = $this->getAllLinks($rawHtml);

        foreach ($links[1] as $link) {
            if (str_contains($link, "://") && stripos($link, $domainName) === false) {
                $externalLinks[$link] = $link;
            }
        }

        return $externalLinks;
    }
}
