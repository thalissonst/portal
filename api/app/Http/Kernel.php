<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * O conjunto de middleware global da aplicação.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
    ];

    /**
     * O conjunto de middleware que deve ser aplicado a cada requisição para o grupo "web".
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api', // Aplica o middleware de limitação de taxa
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * O conjunto de middleware de rotas que deve ser aplicado a cada requisição.
     *
     * @var array
     */
    protected $routeMiddleware = [
        
    ];
};
