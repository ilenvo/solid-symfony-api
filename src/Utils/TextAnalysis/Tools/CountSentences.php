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

use DaveChild\TextStatistics\TextStatistics;

class CountSentences implements ToolsInterface
{
    private TextStatistics $textStatistics;

    public function __construct()
    {
        $this->textStatistics = new TextStatistics();
    }

    public function getResult(string $text): int
    {
        return $this->textStatistics->sentenceCount($text);
    }
}
