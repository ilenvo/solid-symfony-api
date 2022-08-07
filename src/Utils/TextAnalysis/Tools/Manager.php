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

class Manager
{
    public function __construct(
        private readonly CountLetters $countLetters,
        private readonly CountSentences $countSentences,
        private readonly CountSyllables $countSyllables,
        private readonly CountWords $countWords,
        private readonly StringLength $stringLength
    ) {
    }

    public function getCountLetters(): CountLetters
    {
        return $this->countLetters;
    }

    public function getCountSentences(): CountSentences
    {
        return $this->countSentences;
    }

    public function getCountSyllables(): CountSyllables
    {
        return $this->countSyllables;
    }

    public function getCountWords(): CountWords
    {
        return $this->countWords;
    }

    public function getStringLength(): StringLength
    {
        return $this->stringLength;
    }
}
