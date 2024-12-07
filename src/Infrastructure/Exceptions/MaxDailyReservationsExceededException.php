<?php

namespace Src\Infrastructure\Exceptions;

class MaxDailyReservationsExceededException extends \Exception
{
    protected $message = "Este miembro ha excedido el número de reservas diarias de 3.";
}
