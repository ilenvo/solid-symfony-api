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

namespace App\Utils\HtmlAnalysis\Common;

class Factory
{
    public function __construct(
        private readonly Domain $domain,
        private readonly Javascript $javascript
    ) {
    }

    public function domain(): Domain
    {
        return $this->domain;
    }

    public function javascript(): Javascript
    {
        return $this->javascript;
    }
}
