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

namespace App\Utils\HtmlAnalysis;

use App\Utils\HtmlAnalysis\Head\Factory as HeadFactory;
use App\Utils\HtmlAnalysis\Body\Factory as BodyFactory;
use App\Utils\HtmlAnalysis\Common\Factory as CommonFactory;

class Manager
{
    public function __construct(
        private readonly HeadFactory $header,
        private readonly BodyFactory $body,
        private readonly CommonFactory $common,
    ) {
    }

    public function header(): HeadFactory
    {
        return $this->header;
    }

    public function body(): BodyFactory
    {
        return $this->body;
    }

    public function common(): CommonFactory
    {
        return $this->common;
    }
}
