<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 13/10/2018
 * Time: 12:12
 */

include_once 'AbstractDB.php';

class EditerCompteBd extends AbstractDB
{
    public function editerCompte($mail,$mdp,$pseudo)
    {
        $link = $this->getDbLink();
        $query1 = 'SELECT * FROM user where mail = ? and id <> ? ';
        $query2 = 'SELECT * FROM user where pseudo = ? and id <> ?';
        $query3 = 'UPDATE user SET `mail`= ? ,`pass` = ?,`pseudo` = ? WHERE id = ?';

        if ($stmt = mysqli_prepare($link, $query1)) {
            mysqli_stmt_bind_param($stmt, 'si', $mail, $_SESSION['id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $_SESSION['statusEditionCompteMail'] = 'nonValider';
            }
            else {
                if ($stmt = mysqli_prepare($link, $query2)) {
                    mysqli_stmt_bind_param($stmt, 'si', $pseudo, $_SESSION['id']);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        $_SESSION['statusEditionComptePseudo'] = 'nonValider';
                    }
                    else {
                        if ($stmt = mysqli_prepare($link, $query3)) {
                            mysqli_stmt_bind_param($stmt, 'sssi', $mail, $mdp, $pseudo, $_SESSION['id']);
                            mysqli_stmt_execute($stmt);

                            $_SESSION['statusEditerCompte'] = 'valider';
                            $_SESSION['mail'] = $mail;
                            $_SESSION['pseudo'] = $pseudo;
                            $_SESSION['mdp'] = $mdp;

                            $_SESSION['statusEditionComptePseudo'] = '';
                            $_SESSION['statusEditionCompteMail'] = '';
                        }
                    }
                }
            }
        }
    }
}