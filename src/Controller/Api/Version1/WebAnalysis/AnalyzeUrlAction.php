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

namespace App\Controller\Api\Version1\WebAnalysis;

use App\Services\WebAnalysis\AnalyzeUrl\Version1\Processor as AnalyzeUrlProcessor;
use Symfony\Component\Routing\Annotation\Route;
use App\View\ApiResponseProcessorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\WebAnalysis\AnalyzeUrl\Version1\Request\Request as WebUrlAnalyzeRequest;
use App\Services\WebAnalysis\AnalyzeUrl\Version1\Response\Response as WebUrlAnalyzeResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Error\Response as ErrorResponse;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Attributes as OA;

#[
    Route(
        path: '/api/v1/analyze/url',
        name: 'api_rest_route_v1_analyze_url_'),
    OA\Tag(
        name: "web-analysis"
    )
]
class AnalyzeUrlAction extends AbstractController
{
    public function __construct(
        private readonly ApiResponseProcessorInterface $apiResponseProcessor,
        protected readonly AnalyzeUrlProcessor $processor
    ) {
    }

    #[
        Route(
            name: 'analysis',
            methods: 'POST'
        ),
        OA\Post(
            description: 'fancy service description',
            summary: 'fancy service detail description',
            requestBody: new OA\RequestBody(
                description: 'fancy body',
                required: true,
                content: new OA\JsonContent(ref: new Model(type: WebUrlAnalyzeRequest::class))
            ),
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'OK',
                    content: new OA\JsonContent(ref: new Model(type: WebUrlAnalyzeResponse::class))
                ),
                new OA\Response(
                    response: 400,
                    description: 'Bad Request',
                    content: new OA\JsonContent(ref: new Model(type: ErrorResponse::class))
                ),
                new OA\Response(
                    response: 500,
                    description: 'Internal Server Error',
                    content: new OA\JsonContent(ref: new Model(type: ErrorResponse::class))
                ),
            ]
        )
    ]
    public function __invoke(Request $request): JsonResponse
    {
        return $this->apiResponseProcessor->createJsonResponse($this->processor->process($request));
    }
}
