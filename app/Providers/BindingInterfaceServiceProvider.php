<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BindingInterfaceServiceProvider extends ServiceProvider
{

    protected $interfaces = [
        \Src\Domain\V1\Repositories\IUserRepository::class => \Src\Infrastructure\V1\User\UserEloquentRepository::class,
        \Src\Domain\V1\Repositories\ISportRepository::class => \Src\Infrastructure\V1\Sport\SportEloquentRepository::class,
        \Src\Domain\V1\Repositories\ICourtRepository::class => \Src\Infrastructure\V1\Court\CourtEloquentRepository::class,
        \Src\Domain\V1\Repositories\IMemberRepository::class => \Src\Infrastructure\V1\Member\MemberEloquentRepository::class,
        \Src\Domain\V1\Repositories\IReservationRepository::class => \Src\Infrastructure\V1\Reservation\ReservationEloquentRepository::class,

    ];

    public function boot()
    {
        foreach ($this->interfaces as $interface => $class) {
            $this->app->bind($interface, $class);
        }
    }
}
