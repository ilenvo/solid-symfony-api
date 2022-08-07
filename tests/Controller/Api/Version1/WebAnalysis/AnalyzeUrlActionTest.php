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

namespace App\Tests\Controller\Api\Version1\WebAnalysis;

use App\Tests\Controller\ControllerTestCase;
use App\Tests\GuzzleMockHelper;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class AnalyzeUrlActionTest extends ControllerTestCase
{
    public function testAnalysisSuccess(): void
    {
        $htmlResponse = file_get_contents(__DIR__ . '/mock/ilenvo.html', true);

        GuzzleMockHelper::queue(
            new GuzzleResponse(body: $htmlResponse, headers: ['Content-Length' => [4242]])
        );

        $this->client->request(
            SymfonyRequest::METHOD_POST,
            '/api/v1/analyze/url',
            [],
            [],
            $this->httpJsonHeader(),
            '{
                "url": "https://www.ilenvo.com"
            }'
        );
        self::assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        self::assertJsonStringEqualsJsonString(
            file_get_contents(__DIR__ . '/mock/ilenvo-success.json', true),
            $responseContent
        );
    }

    public function testAnalysisInvalidUrl(): void
    {
        $this->client->request(
            SymfonyRequest::METHOD_POST,
            '/api/v1/analyze/url',
            [],
            [],
            $this->httpJsonHeader(),
            '{
                "url": "invalid"
            }'
        );
        self::assertResponseStatusCodeSame(400);

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();
        self::assertJsonContainsArray(
            [
                'code' => 400,
                'status' => 'Bad Request',
                'message' => 'Validation Exception',
            ],
            $responseContent
        );
    }

    public function testAnalysisConnectionException(): void
    {
        GuzzleMockHelper::queue(
            new ConnectException('Error Communicating with Server', new Request('POST', 'test'))
        );

        $this->client->request(
            SymfonyRequest::METHOD_POST,
            '/api/v1/analyze/url',
            [],
            [],
            $this->httpJsonHeader(),
            '{
                "url": "https://www.ilenvo.com"
            }'
        );
        self::assertResponseStatusCodeSame(400);

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();
        self::assertJsonContainsArray(
            [
                'code' => 400,
                'status' => 'Bad Request',
                'message' => 'Error Communicating with Server',
            ],
            $responseContent
        );
    }

    public function testAnalysisInvalidJson(): void
    {
        $this->client->request(
            SymfonyRequest::METHOD_POST,
            '/api/v1/analyze/url',
            [],
            [],
            $this->httpJsonHeader(),
            '{invalid'
        );
        self::assertResponseStatusCodeSame(400);

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();
        self::assertJsonContainsArray(
            [
                'code' => 400,
                'status' => 'Bad Request',
                'message' => 'Invalid JSON provided',
            ],
            $responseContent
        );
    }

    public function testAnalysisRequestException(): void
    {
        GuzzleMockHelper::queue(
            new RequestException('Unknown', new Request('GET', 'test'))
        );

        $this->client->request(
            SymfonyRequest::METHOD_POST,
            '/api/v1/analyze/url',
            [],
            [],
            $this->httpJsonHeader(),
            '{
                "url": "https://www.ilenvo.com"
            }'
        );
        self::assertResponseStatusCodeSame(400);

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();
        self::assertJsonContainsArray(
            [
                'code' => 400,
                'status' => 'Bad Request',
                'message' => 'Unknown',
            ],
            $responseContent
        );
    }

    public function testAnalysisRequestExceptionNoJsonHeader(): void
    {
        GuzzleMockHelper::queue(
            new NotFoundHttpException()
        );

        $this->client->request(
            SymfonyRequest::METHOD_POST,
            '/api/v1/analyze/url',
            [],
            [],
            [],
            '{
                "url": "https://www.ilenvo.com"
            }'
        );
        self::assertResponseStatusCodeSame(404);
    }

    public function testAnalysisNotFound(): void
    {
        GuzzleMockHelper::queue(
            new NotFoundHttpException()
        );

        $this->client->request(
            SymfonyRequest::METHOD_POST,
            '/api/v1/analyze/url',
            [],
            [],
            $this->httpJsonHeader(),
            '{
                "url": "https://www.ilenvo.com"
            }'
        );
        self::assertResponseStatusCodeSame(404);
    }

    public function testAnalysisBadRequest(): void
    {
        GuzzleMockHelper::queue(
            new BadRequestHttpException()
        );

        $this->client->request(
            SymfonyRequest::METHOD_POST,
            '/api/v1/analyze/url',
            [],
            [],
            $this->httpJsonHeader(),
            '{
                "url": "https://www.ilenvo.com"
            }'
        );
        self::assertResponseStatusCodeSame(400);
    }

    public function testServiceUnavailable(): void
    {
        GuzzleMockHelper::queue(
            new ServiceUnavailableHttpException()
        );

        $this->client->request(
            SymfonyRequest::METHOD_POST,
            '/api/v1/analyze/url',
            [],
            [],
            $this->httpJsonHeader(),
            '{
                "url": "https://www.ilenvo.com"
            }'
        );
        self::assertResponseStatusCodeSame(500);
    }

    public function testAnalysisSuccessWithExternalLinks(): void
    {
        $htmlResponse = file_get_contents(__DIR__ . '/mock/hg-buchhofer.html', true);

        GuzzleMockHelper::queue(
            new GuzzleResponse(body: $htmlResponse)
        );

        $this->client->request(
            SymfonyRequest::METHOD_POST,
            '/api/v1/analyze/url',
            [],
            [],
            $this->httpJsonHeader(),
            '{
                "url": "https://www.hg-buchhofer.com"
            }'
        );
        self::assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        self::assertJsonStringEqualsJsonString(
            file_get_contents(__DIR__ . '/mock/hg-buchhofer-success.json', true),
            $responseContent
        );
    }
}
