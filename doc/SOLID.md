# SOLID

[Back to overview](../README.md)

## What is SOLID

SOLID is a widely used principle in object-oriented programming.
SOLID circumscribes five individual principles.

__Other less common principles are, for example:__

- Principle of Least Surprise
- Single-Choice-Prinzip
- Persistence-Closure-Prinzip
- ...

__Meaning of the acronym SOLID__

- __S__ ingle-responsibility principle
- __O__ pen-closed principle
- __L__ iskovsches substitution principle
- __I__ nterface segregation principle
- __D__ ependency inversion principle

__Why should you work like this:__

- Better software maintainability
- Longer lifetime of the software
- Software less prone to errors
- Easier extensibility of the software
- Simplified testability of the software

## What is SOLID in this project

### Single-responsibility

Example handling API requests/responses.

__The controller:__

The controller is only responsible to receive the request and to return the response!

    public function __invoke(Request $request): JsonResponse
    {
        return $this->apiResponseProcessor->createJsonResponse($this->processor->process($request));
    }

__The service processor__

The service processor is the control panel for parsing, handling and returning the response.

    public function process(SymfonyRequest $request): Response
    {
        $requestModel = $this->requestParser->parse($request);
        $requestModel = $this->getRawHtml($requestModel);

        return $this->responseBuilder->buildResponse($requestModel);
    }

__The request parser__

The request parser receives the original request and build and validates a request DTO.

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

__The response builder__

The response builder is responsible to collect some required data and return the response model (DTO).

    public function buildResponse(Request $requestModel): Response
    {
        $responseModel = $this->factory->response();

        // add default analysis data
        $text = $requestModel->getText();

        $responseModel->setLetterCount($this->toolsManager->getCountLetters()->getResult($text));
        $responseModel->setSentencesCount($this->toolsManager->getCountSentences()->getResult($text));
        $responseModel->setSyllablesCount($this->toolsManager->getCountSyllables()->getResult($text));
        $responseModel->setWordCount($this->toolsManager->getCountWords()->getResult($text));
        $responseModel->setStringLength($this->toolsManager->getStringLength()->getResult($text));

        // if full text analysis is requested loop all tagged services and add the results to response
        if ('full' === $requestModel->getAnalysis()) {
            $responseModel = $this->addAdditionalAnalysis($responseModel, $requestModel);
        }

        // add current date
        $responseModel->setCreatedAt(new DateTime());

        return $responseModel;
    }

__The API response processor__

The API response processor is only responsible to build an JsonResponse from the response model.

    public function createJsonResponse(ApiResponseInterface $apiResponse): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($apiResponse, 'json'),
            $apiResponse->getCode(),
            [],
            true
        );
    }

### Open-close

An example here is the using of tagged services to collect data.

Services which are implementing the TextAnalysisHandlerInterface are automatically tagged with text.analysis.

    services:
        _instanceof:
            App\Utils\TextAnalysis\TextAnalysisHandlerInterface:
                tags: ['text.analysis']

The response builder collects all these services.

    public function __construct(
        #[TaggedIterator('text.analysis')] iterable $textAnalyzers,
        private readonly Factory $factory,
        private readonly ToolsManager $toolsManager
    ) {
        $this->textAnalyzers = $textAnalyzers;
    }

Loops them and add the result to the response model.

    private function addAdditionalAnalysis(Response $responseModel, Request $requestModel): Response
    {
        /**
         * @var TextAnalysisHandlerInterface $analyzer
         */
        foreach ($this->textAnalyzers as $analyzer) {
            $resultModel = $analyzer->analyzeString($requestModel->getText());

            $textAnalysisItem = $this->factory->fullTextAnalysis();
            $textAnalysisItem->setName($resultModel->getName());
            $textAnalysisItem->setValue($resultModel->getValue());
            $textAnalysisItem->setDescription($resultModel->getDescription());

            $responseModel->addTextAnalysis($textAnalysisItem);
        }

        return $responseModel;
    }

### Liskovsches substitution

This principle is quite hard to explain, but to completely break it down. Every class which extends another class 
is not changing the behaviour. I know this explanation is not very satisfying, but there are tons of books out there, 
and you are allowed to read them ;-)

An easy example is for instance the Controller which extends the AbstractController. The behaviour is not changed 
and the controller behaves like a controller.

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
        ...
    }

### Interface segregation principle

The easiest example here in this project is the ApiResponseInterface which is used for the response models and the 
ApiResponseProcessor.

    interface ApiResponseInterface
    {
        public function getCode(): int;
    }

example implementation

    class Response implements ApiResponseInterface
    {
        ...
    }

example usage

    public function createJsonResponse(ApiResponseInterface $apiResponse): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($apiResponse, 'json'),
            $apiResponse->getCode(),
            [],
            true
        );
    }

### Dependency inversion principle

A simple example is a service processor which requires the guzzle client. The guzzle client has no dependency to the 
service processor.

    class Processor
    {
        public function __construct(
            private readonly ClientInterface $scanClient,
            private readonly LoggerInterface $logger,
            private readonly RequestParser $requestParser,
            private readonly ResponseBuilder $responseBuilder
            ) {
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

[Back to overview](../README.md)