<?php

namespace Src\Infrastructure\V1\Exceptions;

class HourExceedeedTime extends \Exception
{

    protected $message = "La hora tiene que estar entre las 08:00 y las 22:00";
}
