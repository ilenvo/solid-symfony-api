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

class Link
{
    #[
        Serializer\SerializedName('internalLinks'),
        Serializer\Type('array<App\Services\WebAnalysis\AnalyzeUrl\Version1\Response\LinkItem>')
    ]
    private array $internalLinks = [];

    #[
        Serializer\SerializedName('externalLinks'),
        Serializer\Type('array<App\Services\WebAnalysis\AnalyzeUrl\Version1\Response\LinkItem>')
    ]
    private array $externalLinks = [];

    public function addInternalLink(LinkItem $internalLink): void
    {
        $this->internalLinks[] = $internalLink;
    }

    public function addExternalLink(LinkItem $externalLink): void
    {
        $this->externalLinks[] = $externalLink;
    }
}
