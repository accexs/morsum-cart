<?php

namespace App\Exceptions;

use Exception;

class CartEmptyException extends Exception
{

    public function __construct()
    {
        $message = 'Cart is empty, cannot create order';
        $code = 406;
        parent::__construct($message, $code);
    }
}
