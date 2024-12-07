<?php

namespace Src\Infrastructure\V1\Exceptions;

class NotFoundException extends \Exception
{

    protected $message = "No se ha encontrado este id";
}
