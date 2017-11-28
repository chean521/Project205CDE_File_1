<?php

/*
*	MySQL Runtime Engine, Universal Process Engine
*	Version: 1.0 beta
*	Created By: Oscar Loh, Date: 10 Oct 2017
*       Implementations Class Object
*/

interface MYSQL_BaseObj
{
    public function __construct();
    
    public function SetConnection($host,$id,$pwd,$db);
    
    public function Connect();
    
    public function Disconnect();
    
    public function Single_Line_Query($query,$param,$value);
    
    public function Stored_Proc_Query($method_name,$value);
    
    public function Write($table_name, $param_name, $data);
    
    public function Result_Convert($data);
    
}