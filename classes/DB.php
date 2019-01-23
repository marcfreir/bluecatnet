<?php

/* 
    Created on : 15-Jul-2018, 06:02:39 PM
    Author     : Marc Freir
    License    : This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
*/

class DB
{
    private static function connect()
    {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=db_bluecatnet;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function query($query, $params = array())
    {
        $statement = self::connect()->prepare($query);
        $statement->execute($params);

        if (explode(' ', $query)[0] == 'SELECT')
        {
            $data = $statement->fetchAll();
            return $data;

        }
        

    }
}

?>