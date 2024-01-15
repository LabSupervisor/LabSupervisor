<?php

// Paramètres de la BDD
require '../config/settings.php';

// Inclusion de tous les Repositories
function chargerClasse($classe)
{
    //require '../src/App/Repositories/' . $classe . '.php';
}
spl_autoload_register('chargerClasse');
