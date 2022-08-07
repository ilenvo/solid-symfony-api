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

namespace App\Controller\Api\Version1\TextAnalysis;

use App\Services\TextAnalysis\Analyze\Version1\Processor as AnalyzeProcessor;
use App\View\ApiResponseProcessorInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\TextAnalysis\Analyze\Version1\Request\Request as TextAnalyzeRequest;
use App\Services\TextAnalysis\Analyze\Version1\Response\Response as TextAnalyzeResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Error\Response as ErrorResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[
    Route(
        path: '/api/v1/text/analysis',
        name: 'api_rest_route_v1_text_'),
    OA\Tag(
        name: "text-analysis"
    )
]
class AnalyzeAction extends AbstractController
{
    public function __construct(
        private readonly ApiResponseProcessorInterface $apiResponseProcessor,
        protected readonly AnalyzeProcessor $processor
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
                content: new OA\JsonContent(ref: new Model(type: TextAnalyzeRequest::class))
            ),
            responses: [
                new OA\Response(
                    response: 200,
                    description: 'OK',
                    content: new OA\JsonContent(ref: new Model(type: TextAnalyzeResponse::class))
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
