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

namespace App\Error;

use JMS\Serializer\Annotation as Serializer;

class Violation
{
    #[
        Serializer\SerializedName("path"),
        Serializer\Type("string")
    ]
    private ?string $path = null;

    #[
        Serializer\SerializedName("value"),
        Serializer\Type("string")
    ]
    private ?string $value = null;

    #[
        Serializer\SerializedName("message"),
        Serializer\Type("string")
    ]
    private ?string $message = null;

    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }
}
