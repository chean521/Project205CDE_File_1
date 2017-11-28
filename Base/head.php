<!DOCTYPE html>
<!--
Author: Oscar Loh Kah Chean
Student ID: P14004402, INTI International College Penang
INTI Voting System
Version: beta 1.0.0
-->
<?php
require ('Engines/SessionManager/SessionManager.php');
include_once ('Engines/Config/config.php'); 

$Session = null;
$isLogged = false;
$isAdminLogged = false;

if(!isset($Session))
{
    $Session = new SessionManager();
    $Session->set_session_id();
}

if($Session->session_exist('login') == true)
{
    $getRes = $Session->get_session_data('login');
    if($getRes == true)
    {
        $isLogged = true;
        $login_details = $Session->get_session_data('detail_role');
        if($login_details == 'admin')
        {
            $isAdminLogged = true;
            $GetSetting = simplexml_load_file('Engines/Config/Setting.xml') or die();
            
            $GetCand = (string)$GetSetting->config->allowCand;
        }
    }
}

?>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="API/BootStrapv3.3.7-dist/CSS/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="API/BootStrapv3.3.7-dist/CSS/bootstrap-theme.css" />
        <link rel="stylesheet" type="text/css" href="CSS/Scroll.css" />
        <link rel="stylesheet" type="text/css" href="CSS/style.css" />
        <link rel="shortcut icon" href="images/160.ico" />
        <script type="text/javascript" language="javascript" src="API/JQuery v3.2.1/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="API/BootStrapv3.3.7-dist/JS/bootstrap.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">
                        <img src="images/logo.png" alt="logo" style="width:64px;">
                        &nbsp;INTI Voting System
                    </a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="index.php#container-1">Home</a></li>
                    <li><a href="index.php#container-2">About System</a></li>
                    <li><a href="index.php#container-3">Contact Us</a></li>
                    <li><a href="ActivityStat.php#container-4">Activity Status</a></li>
                    <li><a href="MakeVote.php">Make a vote</a></li>
                    <?php
                    if($isAdminLogged == true)
                    {
                        echo
                          '<li class="dropdown">'
                            . '<a class="dropdown-toggle" data-toggle="dropdown" href="#">'
                                . 'Admin Management <span class="caret"></span>'
                            . '</a>'
                            . '<ul class="dropdown-menu">'
                                . '<li><a href="Admin_ActivityPanel.php">Activity Panel</a></li>'
                                . '<li><a href="Admin_UserAuthorization.php">User Registration Approval</a></li>'
                                . '<li><a href="Admin_ViewAccount.php">View User Account</a></li>'
                            . '</ul>'
                        . '</li>';
                    }
                    ?>
                    
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    if($isLogged == true)
                    {
                        $admin_chg = '';
                        
                        if($isAdminLogged == true)
                        {
                            switch($GetCand)
                            {
                                case 'false':
                                    $can_txt = 'Off';
                                    break;
                                
                                case 'true':
                                    $can_txt = 'On';
                                    break;
                                
                                default:
                                    $can_txt = '';
                                    break;
                            }
                            
                            $admin_chg = '<li><a href="Engines/ChangeCandVote_XML.php"><span class="glyphicon glyphicon-cog"></span> Allow Candidate Vote: <span id="cand_vt_stat">'.$can_txt.'</span></a></li>';
                        }
                        
                        echo '<p class="navbar-text"><span class="glyphicon glyphicon-user"></span> '.$Session->get_session_data('detail_name').'</p>';
                        echo 
                        '<li class="dropdown">'
                        . '<a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-info-sign"></span> Account <span class="caret"></span></a>'
                        . '<ul class="dropdown-menu">'
                            . '<li><a href="#" data-toggle="modal" data-target="#chg_pwd_modal"><span class="glyphicon glyphicon-lock" onclick="SetID("'.$Session->get_session_data('detail_id').'");"></span> Change Password</a></li>'
                            . $admin_chg
                            . '<li><a href="'.$_SERVER['HTTP_HOST'].'/../Engines/Logout.php"><span class="glyphicon glyphicon-off"></span> Log Out</a></li>'
                        . '</ul>'
                        . '</li>';
                    }
                    else
                    {
                        echo '<li><a href="#" data-toggle="modal" data-target="#register_modal"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>';
                        echo '<li><a href="#" data-toggle="modal" data-target="#login_box"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
                    }
                    ?>
                </ul>                
            </div>
        </nav>
        <div class="container" style="margin-top:50px;">
            
        </div>
        <?php include_once('Base/LogModal.php'); ?>
        