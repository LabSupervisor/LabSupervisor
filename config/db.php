<?php
function dbConnect()
{
    try {
        $infosConnexion = parse_ini_file(__DIR__.'\setting.ini');
        // Information de la BDD
        $infoBdd = array(
            'type' => 'mysql',
            'host' => $infosConnexion['database_host'],
            'port' => $infosConnexion['database_port'], // 5432 pour postgreSQL, 3306 pour MySQL
            'charset' => 'UTF8',
            'dbname' => $infosConnexion['database_name'],
            'user' => $infosConnexion['database_user'],
            'pass' => $infosConnexion['database_password'],
        );

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
    } catch (Exception $e) {
        exit('Erreur : '.$e->getMessage());
    }
}
