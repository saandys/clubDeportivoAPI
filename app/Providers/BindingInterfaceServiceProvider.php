<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BindingInterfaceServiceProvider extends ServiceProvider
{

    protected $interfaces = [
        \Src\Domain\Repositories\IUserRepository::class => \Src\Infrastructure\User\UserEloquentRepository::class,
        \Src\Domain\Repositories\ISportRepository::class => \Src\Infrastructure\Sport\SportEloquentRepository::class,
        \Src\Domain\Repositories\ICourtRepository::class => \Src\Infrastructure\Court\CourtEloquentRepository::class,

    ];

    public function boot()
    {
      foreach ($this->interfaces as $interface => $class)
        $this->app->bind($interface, $class);
    }

}
