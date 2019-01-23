<?php

/* 
    Created on : 15-Jul-2018, 06:02:39 PM
    Author     : Marc Freir
    License    : This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
*/

class DB
{
    private $pdo;

    public function __construct($host, $dbname, $username, $password)
    {
        $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }

    public function query($query, $params = array())
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);

        if (explode(' ', $query)[0] == 'SELECT')
        {
            $data = $statement->fetchAll();
            return $data;

        }
        

    }
}

?>