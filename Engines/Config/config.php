<?php

class ConfigurationData{
    
    /* Database Connection */
    public static $database_host        = 'localhost:3306';
    public static $database_id          = 'root';
    public static $database_pw          = '';
    public static $database_db          = 'project205cde';

    /* Google Maps API Access Key */
    public static $GoogleMapKey         = 'AIzaSyCr00eAu1vzNBljgxgFB7PuDk6UeKWrXvM';
    
    /* Picture file uploaded to */
    public static $target_folder        = 'Candidate_pic/';
    
    /* Submit Redirect To */
    public static $redirect_to          = '';
        
    /* Website Version */
    public static function Site_Version()
    {
        $GetSetting = simplexml_load_file('Engines/Config/Setting.xml') or die();
        $Version = $GetSetting->version;
        
        return (string) $Version->interface . '.' . $Version->revision . '.' . $Version->build . ' (' . $Version->attr .')';
    }
    
}