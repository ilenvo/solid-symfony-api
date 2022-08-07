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

use App\Utils\Helper\Encoding;

class Headlines
{
    public function __construct(private readonly Encoding $encoding)
    {
    }

    public function getHeadlines(string $rawHtml): array
    {
        $result = [];
        $h1 = $this->getHeadline($rawHtml, 'h1');
        $h2 = $this->getHeadline($rawHtml, 'h2');
        $h3 = $this->getHeadline($rawHtml, 'h3');
        $h4 = $this->getHeadline($rawHtml, 'h4');
        $h5 = $this->getHeadline($rawHtml, 'h5');

        $result['h1'] = ['count' => count($h1), 'results' => $h1];
        $result['h2'] = ['count' => count($h2), 'results' => $h2];
        $result['h3'] = ['count' => count($h3), 'results' => $h3];
        $result['h4'] = ['count' => count($h4), 'results' => $h4];
        $result['h5'] = ['count' => count($h5), 'results' => $h5];

        return $result;
    }

    private function getHeadline(string $rawHtml, string $tagName): array
    {
        $titles = [];

        preg_match_all("=<" . $tagName . "[^>]*>(.*)</" . $tagName . ">=siU", $rawHtml, $matches);
        if (isset($matches[1]) && is_array($matches)) {
            foreach ($matches[1] as $headline) {
                $headlineCleaned = str_ireplace("\n", "<br />", preg_replace('/\s\s+/', ' ', $headline));
                $titles[] = $this->encoding->fixEncoding(trim(strip_tags($headlineCleaned)));
            }
        }
        return $titles;
    }
}
