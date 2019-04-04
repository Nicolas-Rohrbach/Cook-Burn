<?php
/**
 * Created by PhpStorm.
 * User: a17009559
 * Date: 12/10/2018
 * Time: 12:57
 */
include_once 'AbstractDB.php';

class BdConnection extends AbstractDB
{
    public function connectionBd($login,$mdp){
        //$query = 'SELECT * FROM user WHERE (mail = \'' . $login . '\' or pseudo = \'' . $login . '\') AND (pass = \'' . $mdp . '\')';
        $query = 'SELECT * FROM user WHERE (mail = ? or pseudo = ? ) AND (pass = ?)';
        $link = $this->getDbLink();

        if ($stmt = mysqli_prepare($link, $query)){
            mysqli_stmt_bind_param($stmt,'sss', $login, $login, $mdp);
            mysqli_stmt_execute($stmt);
            $dbResult = mysqli_stmt_get_result($stmt);
            $dbRow = mysqli_fetch_assoc($dbResult);

            if ($dbRow ['status'] == 'admin' || $dbRow ['status'] == 'membre') {
                $_SESSION['login'] = $dbRow ['status'];
                $_SESSION['mail'] = $dbRow ['mail'];
                $_SESSION['id'] = $dbRow ['id'];
                $_SESSION['pseudo'] = $dbRow['pseudo'];
                $_SESSION['mdp'] = $dbRow['pass'];
            }

        }
    }

    public function deconnectionBd()
    {
        $_SESSION = array();
        session_destroy();
    }
}