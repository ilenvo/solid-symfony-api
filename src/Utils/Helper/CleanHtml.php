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

namespace App\Utils\Helper;

use HTMLPurifier;
use HTMLPurifier_Config;

class CleanHtml
{
    private HTMLPurifier $htmlPurifier;

    public function __construct()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('URI.MakeAbsolute', true);
        $config->set('AutoFormat.RemoveEmpty', true);
        $config->set('HTML.Doctype', 'XHTML 1.0 Strict');
        $config->set('HTML.AllowedElements', []);
        $config->set('HTML.AllowedAttributes', []);
        $config->set('CSS.AllowedProperties', []);

        $this->htmlPurifier = new HTMLPurifier($config);
    }

    /**
     * this function cleans a html string
     *
     * first it adds some spaces between tags
     * next it removes all html tags
     * next it removes all double spaces
     */
    public function purifyHtml(string $html): string
    {
        return preg_replace(
            '/\s+/',
            ' ',
            $this->htmlPurifier->purify(str_replace('><', '> <', $html))
        );
    }
}
