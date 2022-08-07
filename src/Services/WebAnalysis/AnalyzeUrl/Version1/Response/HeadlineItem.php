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

namespace App\Services\WebAnalysis\AnalyzeUrl\Version1\Response;

use JMS\Serializer\Annotation as Serializer;

class HeadlineItem
{
    #[
        Serializer\SerializedName('content'),
        Serializer\Type('string')
    ]
    private ?string $content = null;

    public function __construct(?string $content)
    {
        $this->content = $content;
    }
}
