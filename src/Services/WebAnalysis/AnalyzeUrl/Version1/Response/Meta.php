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

class Meta
{
    #[
        Serializer\SerializedName('title'),
        Serializer\Type('string')
    ]
    private ?string $title;

    #[
        Serializer\SerializedName('description'),
        Serializer\Type('string')
    ]
    private ?string $description;

    #[
        Serializer\SerializedName('keywords'),
        Serializer\Type('string')
    ]
    private ?string $keywords;

    #[
        Serializer\SerializedName('encoding'),
        Serializer\Type('string')
    ]
    private ?string $encoding;

    #[
        Serializer\SerializedName('generator'),
        Serializer\Type('string')
    ]
    private ?string $generator;

    #[
        Serializer\SerializedName('robots'),
        Serializer\Type('string')
    ]
    private ?string $robots;

    #[
        Serializer\SerializedName('contentLanguage'),
        Serializer\Type('string')
    ]
    private ?string $contentLanguage;

    #[
        Serializer\SerializedName('language'),
        Serializer\Type('string')
    ]
    private ?string $language;

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setKeywords(?string $keywords): void
    {
        $this->keywords = $keywords;
    }

    public function setEncoding(?string $encoding): void
    {
        $this->encoding = $encoding;
    }

    public function setGenerator(?string $generator): void
    {
        $this->generator = $generator;
    }

    public function setRobots(?string $robots): void
    {
        $this->robots = $robots;
    }

    public function setContentLanguage(?string $contentLanguage): void
    {
        $this->contentLanguage = $contentLanguage;
    }

    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }
}
