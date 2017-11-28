<?php

/*
 *      Session Manager Engine
 *      Control All the Sesssion Related in Websites
 *      Version 1.0beta
 *      Author: Oscar Loh, Date 10 Oct 2017 
 *      Main Engine Site
 */

define('SESS_VER', '1.0beta');
require('Parts/Error_Handling.php');

class SessionManager 
{

    protected $sessionID;

    public function __construct()
    {
        if( !isset($_SESSION) )
        {
            $this->init_session();
        }
    }

    public function init_session()
    {
        session_start();
    }

    public function set_session_id()
    {
        //$this->start_session();
        $this->sessionID = session_id();
    }

    public function get_session_id()
    {
        return $this->sessionID;
    }

    public function destruct_Session()
    {
        session_destroy();
    }

    public function session_exist( $session_name )
    {
        if( isset($_SESSION[$session_name]) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function create_session( $session_name , $is_array = false )
    {
        if( !isset($_SESSION[$session_name])  )
        {
            if( $is_array == true )
            {
                $_SESSION[$session_name] = array();
            }
            else
            {
                $_SESSION[$session_name] = '';
            }
        }
    }

    public function insert_value( $session_name , array $data )
    {
        if( is_array($_SESSION[$session_name]) )
        {
            array_push( $_SESSION[$session_name], $data );
        }
    }

    public function display_session( $session_name )
    {
        echo '<pre>';print_r($_SESSION[$session_name]);echo '</pre>';
    }

    public function remove_session( $session_name = '' )
    {
        if( !empty($session_name) )
        {
            unset( $_SESSION[$session_name] );
        }
        else
        {
            unset($_SESSION);
            //session_unset();
            //session_destroy();
        }
    }

    public function get_session_data( $session_name )
    {
        return $_SESSION[$session_name];
    }

    public function set_session_data( $session_name , $data )
    {
        $_SESSION[$session_name] = $data;
    }

}