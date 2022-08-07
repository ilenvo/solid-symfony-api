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

use App\View\ApiResponseInterface;
use JMS\Serializer\Annotation as Serializer;

class Response implements ApiResponseInterface
{
    #[
        Serializer\SerializedName("code"),
        Serializer\Type("integer")
    ]
    private ?int $code = null;

    #[
        Serializer\SerializedName("status"),
        Serializer\Type("string")
    ]
    private ?string $status = null;

    #[
        Serializer\SerializedName("message"),
        Serializer\Type("string")
    ]
    private ?string $message = null;

    /**
     * @var null|Violation[]
     */
    #[
        Serializer\SerializedName("violations"),
        Serializer\Type("array<App\Error\Violation>")
    ]
    private ?array $violations = null;

    #[
        Serializer\SerializedName("debug"),
        Serializer\Type("array")
    ]
    private ?array $debug;

    public function setCode(?int $code): void
    {
        $this->code = $code;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function setViolations(?array $violations): void
    {
        $this->violations = $violations;
    }

    public function getCode(): int
    {
        return (int)$this->code;
    }

    public function setDebug(?array $debug): void
    {
        $this->debug = $debug;
    }
}
