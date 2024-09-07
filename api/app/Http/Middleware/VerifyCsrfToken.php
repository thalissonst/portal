<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class VerifyCsrfToken extends Middleware
{

    /**
     * Os URIs que devem ser excluídos da verificação CSRF.
     *
     * @var array
     */
    protected $except = [
        '*'
    ];

}
