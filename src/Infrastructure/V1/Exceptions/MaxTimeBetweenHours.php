<?php

namespace Src\Infrastructure\V1\Exceptions;

class MaxTimeBetweenHours extends \Exception
{

    protected $message = "Las reservas tienen que ser de 1 hora únicamente.";
}
