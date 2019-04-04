<?php
/**
 * Created by PhpStorm.
 * User: a17009559
 * Date: 12/10/2018
 * Time: 12:37
 */

include_once 'MODEL/BdConnection.php';
include_once 'CONTROLLER/Accueil.php';

class BaseDeDonnee implements InterfaceController
{
    public function display($data = []) {
        header('location: /Accueil');
    }

    public function connection(){
        $bd = new BdConnection();
        $login = filter_input(INPUT_POST, 'login');
        $mdp = filter_input(INPUT_POST, 'mdp');
        $bd->connectionBd($login, $mdp);

        header('location: /Accueil');
    }

    public function deconnection()
    {
        $bd = new BdConnection();
        $bd->deconnectionBd();

        header('location: /Accueil');
    }
}