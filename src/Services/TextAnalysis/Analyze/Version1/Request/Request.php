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

namespace App\Services\TextAnalysis\Analyze\Version1\Request;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Properties as CustomAssert;
use JMS\Serializer\Annotation as Serializer;
use OpenApi\Attributes as OA;

/**
 * Class Request
 * @package App\Services\TextAnalysis\Analyze\Version1\Request
 */
class Request
{
    private const ANALYSIS = ['simple', 'full'];

    #[
        Assert\NotBlank(),
        CustomAssert\WordCount(wordCount: 2),
        Serializer\SerializedName("text"),
        Serializer\Type("string"),
        OA\Property(example: 'text to analyze')
    ]
    private ?string $text = null;

    #[
        Assert\NotBlank(),
        Assert\Choice(
            choices: self::ANALYSIS,
            message: 'Invalid value. Valid values: simple, full'
        ),
        Serializer\SerializedName("analysis"),
        Serializer\Type("string"),
        OA\Property(example: 'full')
    ]
    private ?string $analysis = null;

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getAnalysis(): ?string
    {
        return $this->analysis;
    }
}
