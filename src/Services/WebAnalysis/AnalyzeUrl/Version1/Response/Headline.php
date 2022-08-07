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

namespace App\Services\WebAnalysis\AnalyzeUrl\Version1\Response;

use JMS\Serializer\Annotation as Serializer;

class Headline
{
    #[
        Serializer\SerializedName('name'),
        Serializer\Type('string')
    ]
    private ?string $name = null;

    #[
        Serializer\SerializedName('count'),
        Serializer\Type('int')
    ]
    private ?int $count = null;

    #[
        Serializer\SerializedName('headlines'),
        Serializer\Type('array<App\Services\WebAnalysis\AnalyzeUrl\Version1\Response\HeadlineItem>')
    ]
    private ?array $headlines = null;

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setCount(?int $count): void
    {
        $this->count = $count;
    }

    public function addHeadlines(HeadlineItem $headline): void
    {
        $this->headlines[] = $headline;
    }
}
