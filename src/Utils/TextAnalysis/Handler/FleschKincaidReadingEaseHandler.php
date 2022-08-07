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

class FleschKincaidReadingEaseHandler implements TextAnalysisHandlerInterface
{
    private TextStatistics $textStatistics;

    public function __construct(private readonly Factory $factory)
    {
        $this->textStatistics = new TextStatistics();
    }

    public function analyzeString(string $text): TextAnalysisResultInterface
    {
        $resultDto = $this->factory->textAnalysisResult();
        $resultDto->setName('FleschKincaidReading');
        $resultDto->setDescription($this->getDescription());

        $resultDto->setValue(
            number_format(
                (float)$this->textStatistics->fleschKincaidReadingEase($text),
                2,
                '.',
                ''
            )
        );

        return $resultDto;
    }

    private function getDescription(): string
    {
        $description = [
            '0-10 Professional',
            '10-30 College graduate',
            '30-50 College',
            '50-60 10th to 12th grade',
            '60-70 8th & 9th grade',
            '70-80 7th grade',
            '80-90 6th grade',
            '90-100 5th grade'
        ];
        return implode('; ', $description);
    }
}
