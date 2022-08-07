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

use App\Utils\Helper\CleanHtml;

class Keywords
{
    private const STOP_WORDS = [
        'und',
        'and',
        'oder',
        'or',
        'der',
        'die',
        'das',
        'the',
        'für',
        'mein',
        'einer',
        'nach',
        'habe',
        'eine',
        'meine',
        'mehr',
        'with'
    ];

    public function __construct(private readonly CleanHtml $cleanHtml)
    {
    }

    public function getTopTen(string $rawHtml): array
    {
        //todo symfony parser crawler
        libxml_use_internal_errors(true);
        $domObject = new \DOMDocument();
        $domObject->loadHTML('<?xml encoding="UTF-8">' . $rawHtml);
        libxml_clear_errors();
        $body = $domObject->getElementsByTagName('body');

        $wordString = null;

        if ($body && 0 < $body->length) {
            $body = $body->item(0);
            $wordString = $this->cleanHtml->purifyHtml((string)$domObject->savehtml($body));
        }

        if (null === $wordString) {
            return [];
        }

        // cleanup the string a little and change all words to lowercase
        $words = mb_strtolower(
            str_replace(
                ["\r", "\r\n", "\n", ".", ",", "?", "!", "'", "»", "©", "/", "&" . ";", "\"", "-", ":", "&amp;"],
                ' ',
                $wordString
            ),
            'UTF-8'
        );

        $wordsArray = str_word_count($words, 1, "ä,ü,ö,ß,Ü,Ä,Ö");

        $newWords = [];
        foreach ($wordsArray as $word) {
            if (strlen($word) >= 4 && strlen($word) < 25) {
                $newWords[] = $word;
            }
        }

        $wordsDiff = array_diff($newWords, self::STOP_WORDS);
        $wordCount = array_count_values($wordsDiff);
        arsort($wordCount);

        $resultsArray = [];
        $i = 0;
        foreach ($wordCount as $keyword => $count) {
            $i++;
            if ($i < 11) {
                $resultsArray[$keyword] = $count;
            }
        }
        return $resultsArray;
    }
}
