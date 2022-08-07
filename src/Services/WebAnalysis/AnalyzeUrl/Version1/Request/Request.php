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

namespace App\Services\WebAnalysis\AnalyzeUrl\Version1\Request;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
use OpenApi\Attributes as OA;

class Request
{
    #[
        Assert\NotBlank(),
        Assert\Url(),
        Serializer\SerializedName("url"),
        Serializer\Type("string"),
        OA\Property(example: 'https://www.ilenvo.com')
    ]
    private ?string $url = null;

    #[
        Serializer\Exclude()
    ]
    private ?string $rawHtml = null;

    #[
        Serializer\Exclude()
    ]
    private ?string $contentLength = null;

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getRawHtml(): ?string
    {
        return $this->rawHtml;
    }

    public function setRawHtml(?string $rawHtml): void
    {
        $this->rawHtml = $rawHtml;
    }

    public function getContentLength(): ?string
    {
        return $this->contentLength;
    }

    public function setContentLength(?string $contentLength): void
    {
        $this->contentLength = $contentLength;
    }
}
