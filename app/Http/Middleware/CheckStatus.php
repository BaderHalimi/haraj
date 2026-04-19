<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckStatus
{
  public function handle($request, Closure $next)
{
    return $next($request);
}


}
