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

namespace App\Services\WebAnalysis\AnalyzeUrl\Version1;

use App\Exception\UrlValidationException;
use App\Services\WebAnalysis\AnalyzeUrl\Version1\Request\Request;
use App\Services\WebAnalysis\AnalyzeUrl\Version1\Request\RequestParser;
use App\Services\WebAnalysis\AnalyzeUrl\Version1\Response\Response;
use App\Services\WebAnalysis\AnalyzeUrl\Version1\Response\ResponseBuilder;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class Processor
{
    public function __construct(
        private readonly ClientInterface $scanClient,
        private readonly LoggerInterface $logger,
        private readonly RequestParser $requestParser,
        private readonly ResponseBuilder $responseBuilder
    ) {
    }

    public function process(SymfonyRequest $request): Response
    {
        $requestModel = $this->requestParser->parse($request);
        $requestModel = $this->getRawHtml($requestModel);

        return $this->responseBuilder->buildResponse($requestModel);
    }

    private function getRawHtml(Request $requestModel): Request
    {
        try {
            $responseObject = $this->scanClient->request(SymfonyRequest::METHOD_GET, $requestModel->getUrl());
        } catch (ConnectException $exc) {
            $this->logger->error($exc->getMessage(), ['exception' => $exc, 'errorCode' => '5f560ce0']);
            throw new UrlValidationException($exc->getCode(), $exc->getMessage());
        } catch (GuzzleException $exc) {
            $this->logger->error($exc->getMessage(), ['exception' => $exc, 'errorCode' => '1bb8c45b']);
            throw new UrlValidationException($exc->getCode(), $exc->getMessage());
        }

        $requestModel->setRawHtml($responseObject->getBody()->getContents());

        if (isset($responseObject->getHeader('Content-Length')[0])) {
            $contentLength = number_format(($responseObject->getHeader('Content-Length')[0] / 1024), 2) . ' KB';
        } else {
            $contentLength = null;
        }
        $requestModel->setContentLength($contentLength);

        return $requestModel;
    }
}
