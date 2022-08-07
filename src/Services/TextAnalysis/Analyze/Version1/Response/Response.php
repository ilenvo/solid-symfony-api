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

namespace App\Services\TextAnalysis\Analyze\Version1\Response;

use App\View\ApiResponseInterface;
use DateTime;
use JMS\Serializer\Annotation as Serializer;

class Response implements ApiResponseInterface
{
    #[
        Serializer\SerializedName('stringLength'),
        Serializer\Type('integer')
    ]
    private ?int $stringLength = null;

    #[
        Serializer\SerializedName('wordCount'),
        Serializer\Type('integer')
    ]
    private ?int $wordCount = null;

    #[
        Serializer\SerializedName('letterCount'),
        Serializer\Type('integer')
    ]
    private ?int $letterCount = null;

    #[
        Serializer\SerializedName('sentencesCount'),
        Serializer\Type('integer')
    ]
    private ?int $sentencesCount = null;

    #[
        Serializer\SerializedName('syllablesCount'),
        Serializer\Type('integer')
    ]
    private ?int $syllablesCount = null;

    /**
     * @var FullTextAnalysis[]|null
     */
    #[
        Serializer\SerializedName('textAnalysis'),
        Serializer\Type('array<App\Services\TextAnalysis\Analyze\Version1\Response\FullTextAnalysis>')
    ]
    private ?array $textAnalysis = null;

    #[
        Serializer\SerializedName('createdAt'),
        Serializer\Type('DateTime')
    ]
    private ?DateTime $createdAt = null;

    public function setStringLength(?int $stringLength): void
    {
        $this->stringLength = $stringLength;
    }

    public function setWordCount(?int $wordCount): void
    {
        $this->wordCount = $wordCount;
    }

    public function setLetterCount(?int $letterCount): void
    {
        $this->letterCount = $letterCount;
    }

    public function setSentencesCount(?int $sentencesCount): void
    {
        $this->sentencesCount = $sentencesCount;
    }

    public function setSyllablesCount(?int $syllablesCount): void
    {
        $this->syllablesCount = $syllablesCount;
    }

    public function addTextAnalysis(FullTextAnalysis $textAnalysis): void
    {
        $this->textAnalysis[] = $textAnalysis;
    }

    public function setCreatedAt(?DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCode(): int
    {
        return 200;
    }
}
