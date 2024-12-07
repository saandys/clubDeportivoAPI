<?php

namespace Src\Infrastructure\V1\Exceptions;

class CourtAlreadyBookedException extends \Exception
{

    protected $message = "Esta pista está ya reservada";
}
