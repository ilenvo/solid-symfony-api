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

class Content
{
    #[
        Serializer\SerializedName('headlines'),
        Serializer\Type('array<App\Services\WebAnalysis\AnalyzeUrl\Version1\Response\Headline>')
    ]
    private ?array $headlines = null;

    #[
        Serializer\SerializedName('keywords'),
        Serializer\Type('array<App\Services\WebAnalysis\AnalyzeUrl\Version1\Response\Keyword>')
    ]
    private ?array $keywords = null;

    #[
        Serializer\SerializedName('links'),
        Serializer\Type(Link::class)
    ]
    private ?Link $links = null;

    public function setHeadlines(?array $headlines): void
    {
        $this->headlines = $headlines;
    }

    public function setKeywords(?array $keywords): void
    {
        $this->keywords = $keywords;
    }

    public function setLinks(?Link $links): void
    {
        $this->links = $links;
    }
}
