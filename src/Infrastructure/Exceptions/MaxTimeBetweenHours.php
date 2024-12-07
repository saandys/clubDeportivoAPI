<?php

namespace Src\Infrastructure\Exceptions;

class MaxTimeBetweenHours extends \Exception {

    protected $message = "Las reservas tienen que ser de 1 hora únicamente.";

 }
