<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * O namespace padrão para as rotas.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Registrar os serviços de roteamento da aplicação.
     *
     * @return void
     */
    public function boot()
    {
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/web.php'));
        Route::middleware('api')->namespace($this->namespace)->group(base_path('routes/api.php'));
    }

    /**
     * Registrar os serviços de roteamento da aplicação.
     *
     * @return void
     */
    public function map()
    {
        //
    }
}
