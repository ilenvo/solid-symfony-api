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

namespace App\Utils\TextAnalysis\Handler;

use App\Utils\TextAnalysis\DTO\Factory;
use App\Utils\TextAnalysis\TextAnalysisHandlerInterface;
use App\Utils\TextAnalysis\TextAnalysisResultInterface;
use LanguageDetector\LanguageDetector;

class LanguageDetectionHandler implements TextAnalysisHandlerInterface
{
    private LanguageDetector $languageDetector;

    public function __construct(private readonly Factory $factory)
    {
        $this->languageDetector = new LanguageDetector();
    }

    public function analyzeString(string $text): TextAnalysisResultInterface
    {
        $resultDto = $this->factory->textAnalysisResult();
        $resultDto->setName('LanguageDetection');
        $resultDto->setDescription('Estimated language of provided text.');
        $resultDto->setValue((string)$this->languageDetector->evaluate($text)->getLanguage());

        return $resultDto;
    }
}
