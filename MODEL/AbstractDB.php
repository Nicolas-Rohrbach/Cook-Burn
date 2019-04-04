<?php
/**
 * Created by PhpStorm.
 * User: b17014741
 * Date: 11/10/2018
 * Time: 14:56
 */

abstract class AbstractDB
{
    protected function getDbLink() {
        $dbLink = mysqli_connect('mysql-cook-and-burn.alwaysdata.net', '167335', 'azerty')
        or die('Erreur de connexion au serveur : ' . mysqli_connect_error());
        mysqli_select_db($dbLink , 'cook-and-burn_bd')
        or die('Erreur dans la sélection de la base : ' . mysqli_error($dbLink));

        return $dbLink;
    }
}