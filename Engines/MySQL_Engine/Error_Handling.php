<?php

/*
*	MySQL Runtime Engine, Universal Process Engine
*	Version: 1.0 beta
*	Created By: Oscar Loh, Date: 10 Oct 2017
 *      Exception Handling Engine
*/

class DataException extends Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

class ConnectionException extends Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

class QueryException extends Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

class ResultException extends Exception
{
    public function __construct($message = null, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

