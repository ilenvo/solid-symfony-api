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

use JMS\Serializer\Annotation as Serializer;

class FullTextAnalysis
{
    #[
        Serializer\SerializedName('name'),
        Serializer\Type('string')
    ]
    private ?string $name = null;

    #[
        Serializer\SerializedName('value'),
        Serializer\Type('string')
    ]
    private ?string $value = null;

    #[
        Serializer\SerializedName('description'),
        Serializer\Type('string')
    ]
    private ?string $description = null;

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
