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

namespace App\Services\TextAnalysis\Analyze\Version1\Request;

use App\Exception\InvalidRequestException;
use App\Validator\RequestValidator;
use JMS\Serializer\Exception\Exception as SerializerInterfaceException;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class RequestParser
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly RequestValidator $requestValidator
    ) {
    }

    public function parse(SymfonyRequest $request): Request
    {
        /* @var Request $requestModel */
        try {
            $requestModel = $this->serializer->deserialize($request->getContent(), Request::class, 'json');
        } catch (SerializerInterfaceException $exception) {
            throw new InvalidRequestException('Invalid JSON provided');
        }

        // if the request is invalid an exception is thrown, the response will be build by a custom exception listener.
        $this->requestValidator->validate($requestModel);

        return $requestModel;
    }
}
