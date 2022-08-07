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

namespace App\Tests\Controller\Api\Version1\TextAnalysis;

use App\Tests\Controller\ControllerTestCase;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class AnalyzeActionTest extends ControllerTestCase
{
    public function testAnalysisSuccess(): void
    {
        $this->client->request(
            SymfonyRequest::METHOD_POST,
            '/api/v1/text/analysis',
            [],
            [],
            $this->httpJsonHeader(),
            '{
                "text": "This is an very easy sentence. You should easy be able to unserstand this",
                "analysis": "full"
            }'
        );
        self::assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        self::assertJsonContainsArray(
            [
                'stringLength' => 73,
                'wordCount' => 14,
                'letterCount' => 59,
                'sentencesCount' => 2,
                'syllablesCount' => 20,
                'textAnalysis' => [
                    [
                        'name' => 'FleschKincaidGradeLevel',
                        'value' => '4.80',
                        'description' => 'Estimated reading grade level, to fully understand a text.'
                    ],
                    [
                        'name' => 'FleschKincaidReading',
                        'value' => '72.80',
                        'description' => '0-10 Professional; 10-30 College graduate; 30-50 College; 50-60 10th to 12th grade; 60-70 8th & 9th grade; 70-80 7th grade; 80-90 6th grade; 90-100 5th grade'
                    ],
                    [
                        'name' => 'LanguageDetection',
                        'value' => 'en',
                        'description' => 'Estimated language of provided text.'
                    ],
                ]
            ],
            $responseContent
        );
    }

    public function testAnalysisInvalidJson(): void
    {
        $this->client->request(
            'POST',
            '/api/v1/text/analysis',
            [],
            [],
            $this->httpJsonHeader(),
            '{invalid'
        );
        self::assertResponseStatusCodeSame(SymfonyResponse::HTTP_BAD_REQUEST);

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

    public function testAnalysisWithViolation(): void
    {
        $this->client->request(
            'POST',
            '/api/v1/text/analysis',
            [],
            [],
            $this->httpJsonHeader(),
            '{
                "text": "This is an very easy sentence. You should easy be able to unserstand this",
                "analysis": "invalid"
            }'
        );
        self::assertResponseStatusCodeSame(SymfonyResponse::HTTP_BAD_REQUEST);

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        self::assertJsonContainsArray(
            [
                'code' => 400,
                'status' => 'Bad Request',
                'message' => 'Validation Exception',
                'violations' => [
                    [
                        'path' => 'analysis',
                        'value' => 'invalid',
                        'message' => 'Invalid value. Valid values: simple, full'
                    ]
                ]
            ],
            $responseContent
        );
    }

    public function testAnalysisWithViolationEmptyString(): void
    {
        $this->client->request(
            'POST',
            '/api/v1/text/analysis',
            [],
            [],
            $this->httpJsonHeader(),
            '{
                "text": "This is an very easy sentence. You should easy be able to unserstand this",
                "analysis": ""
            }'
        );
        self::assertResponseStatusCodeSame(SymfonyResponse::HTTP_BAD_REQUEST);

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        self::assertJsonContainsArray(
            [
                'code' => 400,
                'status' => 'Bad Request',
                'message' => 'Validation Exception',
                'violations' => [
                    [
                        'path' => 'analysis',
                        'value' => '',
                        'message' => 'This value should not be blank.'
                    ]
                ]
            ],
            $responseContent
        );
    }
}
