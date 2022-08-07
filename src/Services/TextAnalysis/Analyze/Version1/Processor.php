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

namespace App\Services\TextAnalysis\Analyze\Version1;

use App\Services\TextAnalysis\Analyze\Version1\Request\RequestParser;
use App\Services\TextAnalysis\Analyze\Version1\Response\Response;
use App\Services\TextAnalysis\Analyze\Version1\Response\ResponseBuilder;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Processor
{
    public function __construct(
        private readonly RequestParser $requestParser,
        private readonly ResponseBuilder $responseBuilder
    ) {
    }

    public function process(SymfonyRequest $request): Response
    {
        $requestModel = $this->requestParser->parse($request);
        // if you want to save some data to database or search in db you can do it here

        return $this->responseBuilder->buildResponse($requestModel);
    }
}
