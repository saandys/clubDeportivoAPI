<?php

namespace Src\Infrastructure\Exceptions;

class CourtAlreadyBookedException extends \Exception
{

    protected $message = "Esta pista está ya reservada";
}
