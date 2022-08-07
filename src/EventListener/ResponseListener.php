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

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    private PerformanceListener $perfomanceListener;

    public function __construct(PerformanceListener $perfomanceListener)
    {
        $this->perfomanceListener = $perfomanceListener;
    }

    public function __invoke(ResponseEvent $event): void
    {
        if (str_contains($event->getRequest()->get('_route', ''), 'api_rest_route_')) {
            $event->getResponse()->headers->set(
                'X-Script-Time-Seconds',
                $this->perfomanceListener->getScriptSeconds()
            );
        }
    }
}
