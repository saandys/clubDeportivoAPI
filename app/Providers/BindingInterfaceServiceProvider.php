<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BindingInterfaceServiceProvider extends ServiceProvider
{

    protected $interfaces = [
        \Src\Domain\Repositories\IUserRepository::class => \Src\Infrastructure\User\UserEloquentRepository::class,
    ];
    public function boot()
    {
      foreach ($this->interfaces as $interface => $class)
        $this->app->bind($interface, $class);
    }

}
