<?php

namespace Src\Infrastructure\Exceptions;

class MemberAlreadyHasReservationException extends \Exception {

    protected $message = "Este miembro ya ha reservado una pista a esa hora";

 }
