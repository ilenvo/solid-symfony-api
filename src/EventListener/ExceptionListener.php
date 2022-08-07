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

namespace App\EventListener;

use App\Error\Factory;
use App\Exception\ExceptionInterface;
use App\View\ApiResponseProcessorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionListener
{
    private LoggerInterface $logger;

    private ApiResponseProcessorInterface $apiResponseProcessor;

    private Factory $errorFactory;

    private bool $isDebug;

    public function __construct(
        LoggerInterface $logger,
        ApiResponseProcessorInterface $apiResponseProcessor,
        Factory $errorFactory,
        bool $isDebug
    ) {
        $this->logger = $logger;
        $this->apiResponseProcessor = $apiResponseProcessor;
        $this->errorFactory = $errorFactory;
        $this->isDebug = $isDebug;
    }

    public function __invoke(ExceptionEvent $event)
    {
        if (
            !$event->isMainRequest() ||
            !$this->acceptsJson($event) ||
            !str_contains($event->getRequest()->get('_route', ''), 'api_rest_route_')
        ) {
            return;
        }

        $exception = $event->getThrowable();
        $statusCode = $this->resolveCode($exception);

        $this->logger->error($exception->getMessage(), ['exception' => $exception]);

        $errorResponseModel = $this->errorFactory->response();
        $errorResponseModel->setCode($statusCode);
        $errorResponseModel->setStatus($this->getStatus($statusCode));
        $errorResponseModel->setMessage($exception->getMessage());

        if ($exception instanceof ExceptionInterface) {
            $errorResponseModel->setViolations($exception->getViolations());
        }

        if ($this->isDebug) {
            $errorResponseModel->setDebug(
                explode(
                    PHP_EOL,
                    sprintf(
                        '%s (%d): %s' . PHP_EOL . '%s',
                        $exception->getFile(),
                        $exception->getLine(),
                        get_class($exception),
                        $exception->getTraceAsString()
                    )
                )
            );
        }

        $event->setResponse($this->apiResponseProcessor->createJsonResponse($errorResponseModel));
    }

    private function resolveCode(Throwable $throwable): int
    {
        if ($throwable instanceof ExceptionInterface) {
            $statusCode = max($throwable->getCode(), SymfonyResponse::HTTP_BAD_REQUEST);
        } elseif ($throwable instanceof NotFoundHttpException) {
            $statusCode = SymfonyResponse::HTTP_NOT_FOUND;
        } elseif ($throwable instanceof BadRequestHttpException) {
            $statusCode = SymfonyResponse::HTTP_BAD_REQUEST;
        } else {
            $statusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $statusCode;
    }

    private function getStatus(int $statusCode): string
    {
        return SymfonyResponse::$statusTexts[$statusCode] ?? 'Not Resolved';
    }

    private function acceptsJson(ExceptionEvent $event): bool
    {
        return 0 < count(
                array_filter(
                    $event->getRequest()->getAcceptableContentTypes(),
                    static fn(string $accept) => false !== stripos($accept, 'json')
                )
            );
    }
}
