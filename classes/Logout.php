<?php

/* 
    Created on : 15-Jul-2018, 06:02:39 PM
    Author     : Marc Freir
    License    : This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
*/

class Logout
{
    public static function isLoggingOut()
    {
        if (isset($_COOKIE['BCNID']))
        {
            if (isset($_COOKIE['BCNID_'])){
                session_start();
                session_destroy();
            }
            session_start();
            session_destroy();
        }
    }
}
?>