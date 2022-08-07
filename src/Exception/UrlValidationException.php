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

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UrlValidationException extends HttpException implements ExceptionInterface
{
    private ?string $errorCode = null;

    public function __construct(int $statusCode, ?string $message = '', ?string $errorCode = '')
    {
        $this->errorCode = $errorCode;

        parent::__construct($statusCode, $message, null, [], 0);
    }

    public function getViolations(): ?array
    {
        return null;
    }
}
