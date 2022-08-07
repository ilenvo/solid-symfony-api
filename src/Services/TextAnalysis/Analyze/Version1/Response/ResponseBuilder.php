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

namespace App\Services\TextAnalysis\Analyze\Version1\Response;

use App\Services\TextAnalysis\Analyze\Version1\Request\Request;
use App\Utils\TextAnalysis\TextAnalysisHandlerInterface;
use DateTime;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use App\Utils\TextAnalysis\Tools\Manager as ToolsManager;

class ResponseBuilder
{
    private iterable $textAnalyzers;

    public function __construct(
        #[TaggedIterator('text.analysis')] iterable $textAnalyzers,
        private readonly Factory $factory,
        private readonly ToolsManager $toolsManager
    ) {
        $this->textAnalyzers = $textAnalyzers;
    }

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
}
