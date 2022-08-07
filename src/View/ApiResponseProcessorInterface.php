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

use Symfony\Component\HttpFoundation\JsonResponse;

interface ApiResponseProcessorInterface
{
    public function createJsonResponse(ApiResponseInterface $apiResponse): JsonResponse;
}
