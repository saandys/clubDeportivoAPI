<?php

namespace Src\Infrastructure\Exceptions;

class NotFoundException extends \Exception
{

    protected $message = "No se ha encontrado este id";
}
