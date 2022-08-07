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

use App\View\ApiResponseInterface;
use JMS\Serializer\Annotation as Serializer;

class Response implements ApiResponseInterface
{
    #[
        Serializer\SerializedName('url'),
        Serializer\Type('string')
    ]
    private ?string $url = null;

    #[
        Serializer\SerializedName('domainName'),
        Serializer\Type('string')
    ]
    private ?string $domainName = null;

    #[
        Serializer\SerializedName('contentLength'),
        Serializer\Type('string')
    ]
    private ?string $contentLength = null;

    #[
        Serializer\SerializedName('metas'),
        Serializer\Type(Meta::class)
    ]
    private ?Meta $metas = null;

    #[
        Serializer\SerializedName('content'),
        Serializer\Type(Content::class)
    ]
    private ?Content $content = null;

    #[
        Serializer\SerializedName('javascript'),
        Serializer\Type('array<App\Services\WebAnalysis\AnalyzeUrl\Version1\Response\JavascriptItem>')
    ]
    private ?array $javascripts = null;

    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    public function setDomainName(?string $domainName): void
    {
        $this->domainName = $domainName;
    }

    public function setContentLength(?string $contentLength): void
    {
        $this->contentLength = $contentLength;
    }

    public function setMetas(?Meta $metas): void
    {
        $this->metas = $metas;
    }

    public function setContent(?Content $content): void
    {
        $this->content = $content;
    }

    public function addJavascript(JavascriptItem $javascript): void
    {
        $this->javascripts[] = $javascript;
    }

    public function getCode(): int
    {
        return 200;
    }
}
