<?php

/* 
    Created on : 15-Jul-2018, 06:02:39 PM
    Author     : Marc Freir
    License    : This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
*/

class Login
{
    public static function isLoggedIn()
    {
        if (isset($_COOKIE['BCNID']))
        {
            if (DB::query('SELECT logintoken_userid FROM tb_login_tokens WHERE logintoken=:logintoken', array(':logintoken'=>sha1($_COOKIE['BCNID']))))
            {
                $logintokenuserid = DB::query('SELECT logintoken_userid FROM tb_login_tokens WHERE logintoken=:logintoken', array(':logintoken'=>sha1($_COOKIE['BCNID'])))[0]['logintoken_userid'];
                if (isset($_COOKIE['BCNID_']))
                {
                    return $logintokenuserid;
                }
                else
                {
                    $cstrong = true;
                    $logintoken = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                    DB::query('INSERT INTO tb_login_tokens VALUES (\'\', :logintoken, :logintoken_userid)', array(':logintoken'=>sha1($logintoken), ':logintoken_userid'=>$logintokenuserid));
                    DB::query('DELETE FROM tb_login_tokens WHERE logintoken=:logintoken', array(':logintoken'=>sha1($_COOKIE['BCNID'])));

                    setcookie("BCNID", $logintoken, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                    setcookie("BCNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

                    return $logintokenuserid;
                }


            }
        }
        return false;
    }
}

?>