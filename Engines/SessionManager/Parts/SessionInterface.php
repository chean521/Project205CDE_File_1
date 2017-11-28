<?php

/*
 *      Session Manager Engine
 *      Control All the Sesssion Related in Websites
 *      Version 1.0beta
 *      Author: Oscar Loh, Date 10 Oct 2017 
 *      Implementation Site
 */

interface SessionInterface 
{
    public function __construct();
    
    public function startSession();
    
    public function __set($name,$value);
    
    public function __get($name);
    
    public function __unset($name);
    
    public function destory();
}
