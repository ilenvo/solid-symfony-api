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

namespace App\Utils\HtmlAnalysis\Body;

class Factory
{
    public function __construct(
        private readonly Headlines $headlines,
        private readonly Links $links,
        private readonly Keywords $keywords
    ) {
    }

    public function headlines(): Headlines
    {
        return $this->headlines;
    }

    public function links(): Links
    {
        return $this->links;
    }

    public function keywords(): Keywords
    {
        return $this->keywords;
    }
}
