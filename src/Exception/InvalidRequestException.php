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

use App\Error\Violation;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class InvalidRequestException extends BadRequestHttpException implements ExceptionInterface
{
    /**
     * @var Violation[]|null
     */
    private ?array $violations = null;

    public function addViolation(Violation $violation): void
    {
        $this->violations[] = $violation;
    }

    /**
     * @return Violation[]|null
     */
    public function getViolations(): ?array
    {
        return $this->violations;
    }
}
