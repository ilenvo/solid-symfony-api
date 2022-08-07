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

class Factory
{
    public function response(): Response
    {
        return new Response();
    }

    public function meta(): Meta
    {
        return new Meta();
    }

    public function link(): Link
    {
        return new Link();
    }

    public function linkItem(?string $link): LinkItem
    {
        return new LinkItem($link);
    }

    public function javascriptItem(?string $script): JavascriptItem
    {
        return new JavascriptItem($script);
    }

    public function content(): Content
    {
        return new Content();
    }

    public function headline(): Headline
    {
        return new Headline();
    }

    public function headlineItem(?string $content): HeadlineItem
    {
        return new HeadlineItem($content);
    }

    public function keyword(): Keyword
    {
        return new Keyword();
    }
}
