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

namespace App\View;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseProcessor implements ApiResponseProcessorInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function createJsonResponse(ApiResponseInterface $apiResponse): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($apiResponse, 'json'),
            $apiResponse->getCode(),
            [],
            true
        );
    }
}
