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

class Factory
{
    public function response(): Response
    {
        return new Response();
    }

    public function fullTextAnalysis(): FullTextAnalysis
    {
        return new FullTextAnalysis();
    }
}
