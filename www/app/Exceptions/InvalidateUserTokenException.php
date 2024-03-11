<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class InvalidateUserTokenException extends Exception
{
    protected $code = 403;
    protected $message = "User token don't match our records";
}
