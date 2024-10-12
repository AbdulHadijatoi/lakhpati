<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'easypaisa/*',  // This will exclude all routes under 'easypaisa'
        'easypaisa',    // Optionally, you can also exclude the base 'easypaisa' route
    ];
}
