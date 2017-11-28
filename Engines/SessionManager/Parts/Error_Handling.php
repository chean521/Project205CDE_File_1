<?php


/*
 *      Session Manager Engine
 *      Control All the Sesssion Related in Websites
 *      Version 1.0beta
 *      Author: Oscar Loh, Date 10 Oct 2017 
 *      Error Handling Site
 */

class SessionDataException extends Exception
{
    public function __construct($message = null, $code = 0, Exception $previous = null){
        parent::__construct($message, $code, $previous);
    }
}