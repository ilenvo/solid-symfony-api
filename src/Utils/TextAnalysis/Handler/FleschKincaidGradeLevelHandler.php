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
use DaveChild\TextStatistics\TextStatistics;

class FleschKincaidGradeLevelHandler implements TextAnalysisHandlerInterface
{
    private TextStatistics $textStatistics;

    public function __construct(private readonly Factory $factory)
    {
        $this->textStatistics = new TextStatistics();
    }

    public function analyzeString(string $text): TextAnalysisResultInterface
    {
        $resultDto = $this->factory->textAnalysisResult();
        $resultDto->setName('FleschKincaidGradeLevel');
        $resultDto->setDescription($this->getDescription());

        $resultDto->setValue(
            number_format(
                (float)$this->textStatistics->fleschKincaidGradeLevel($text),
                2,
                '.',
                ''
            )
        );

        return $resultDto;
    }

    private function getDescription(): string
    {
        return 'Estimated reading grade level, to fully understand a text.';
    }
}
