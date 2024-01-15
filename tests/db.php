<?php

function dbConnect()
{
    try
    {
        $infoBdd = include 'C:\Program Files\Ampps\www\LabSupervisor\config\config.php';

        $hostname = $infoBdd['host'];
        $mydbname = $infoBdd['dbname'];
        $myusername = $infoBdd['user'];
        $mypassword = $infoBdd['pass'];
        $mydriver = $infoBdd['type'];
        $myport = $infoBdd['port'];
        $mycharset = $infoBdd['charset'];

        // Connexion PDO
        $db = new PDO("$mydriver:dbname=$mydbname;host=$hostname;port=$myport;options='--client_encoding=$mycharset'", $myusername, $mypassword, [PDO::MYSQL_ATTR_LOCAL_INFILE => true]);
        $db->exec("SET NAMES 'UTF8'");

        return $db;
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
}
