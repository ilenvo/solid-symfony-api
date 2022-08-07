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

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class PerformanceListener
{
    private float $startTime = 0.00;

    public function onKernelRequest(RequestEvent $event): void
    {
        $this->startTime = microtime(true);
    }

    public function getScriptSeconds(): string
    {
        return (string)round(microtime(true) - $this->startTime, 6);
    }
}
