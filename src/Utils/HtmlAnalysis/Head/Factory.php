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

namespace App\Utils\HtmlAnalysis\Head;

class Factory
{
    public function __construct(private readonly Metas $metas)
    {
    }

    public function getMetas(): Metas
    {
        return $this->metas;
    }
}
