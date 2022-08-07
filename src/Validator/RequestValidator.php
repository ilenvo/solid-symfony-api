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

namespace App\Validator;

use App\Error\Factory as ErrorFactory;
use App\Exception\Factory as ExceptionFactory;
use App\Exception\InvalidRequestException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestValidator
{
    private ValidatorInterface $validator;

    private ErrorFactory $errorFactory;

    private ExceptionFactory $exceptionFactory;

    public function __construct(
        ValidatorInterface $validator,
        ErrorFactory $errorFactory,
        ExceptionFactory $exceptionFactory
    ) {
        $this->validator = $validator;
        $this->errorFactory = $errorFactory;
        $this->exceptionFactory = $exceptionFactory;
    }

    public function validate(object $request): void
    {
        $violations = $this->validator->validate($request);
        if (0 < count($violations)) {
            throw $this->createInvalidRequestException($violations);
        }
    }

    private function createInvalidRequestException(ConstraintViolationListInterface $violations
    ): InvalidRequestException {
        $exception = $this->exceptionFactory->invalidRequestException();
        foreach ($violations as $violation) {
            $violationModel = $this->errorFactory->violation();
            $violationModel->setMessage($violation->getMessage());
            $violationModel->setPath($violation->getPropertyPath());
            $violationModel->setValue(
                is_object($violation->getInvalidValue()) ? 'class' : $violation->getInvalidValue()
            );
            $exception->addViolation($violationModel);
        }

        return $exception;
    }
}
