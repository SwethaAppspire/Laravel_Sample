<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestTimer
{
   protected float $startTime;
   public function handle(Request $request, Closure $next): Response

   {
    $this->startTime = microtime(true);
    $response = $next($request);
    $duration = (microtime(true) - $this->startTime) * 1000;
    $response->headers->set(
        'X-Duration-Ms',
        number_format($duration,2)
    );
    return $response;
   }
   public function terminate(Request $request, Response $response): void
    {
        logger('Request completed in' .$response->headers->get('X-Duration-Ms') . 'ms');
    }
}
