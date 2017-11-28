<?php

$GetSetting = simplexml_load_file('Config/Setting.xml') or die();

$GetCand = (string)$GetSetting->config->allowCand;
$change = '';

switch($GetCand)
{
    case 'true':
        $change = 'false';
        break;
    
    case 'false':
        $change = 'true';
        break;
}

$GetSetting->config->allowCand = $change;
$GetSetting->asXML('Config/Setting.xml');

header('Location: '.$_SERVER['HTTP_REFERRER'].'/project205cde/index.php');
exit();
