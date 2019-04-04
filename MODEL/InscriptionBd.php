<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 13/10/2018
 * Time: 11:34
 */

include_once 'AbstractDB.php';

class InscriptionBd extends AbstractDB
{
    public function inscrire($mail, $mdp, $status, $pseudo)
    {
        $link = $this->getDbLink();
        $query1 = 'SELECT * FROM user where mail = ?';
        $query2 = 'SELECT * FROM user where pseudo = ?';
        $query3 = 'INSERT INTO user (mail, pass, status, pseudo) values (?,?,?,?)';

        if ($stmt = mysqli_prepare($link, $query1)) {
            mysqli_stmt_bind_param($stmt, 's', $mail);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $_SESSION['statusInscriptionMail'] = 'nonValider';
            } else {
                if ($stmt = mysqli_prepare($link, $query2)) {
                    mysqli_stmt_bind_param($stmt, 's', $pseudo);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        $_SESSION['statusInscriptionPseudo'] = 'nonValider';
                    } else {
                        if ($stmt = mysqli_prepare($link, $query3)) {
                            mysqli_stmt_bind_param($stmt, 'ssss', $mail, $mdp, $status, $pseudo);
                            mysqli_stmt_execute($stmt);

                            $_SESSION['statusInscription'] = 'valider';
                            $_SESSION['statusInscriptionMail'] = '';
                            $_SESSION['statusInscriptionPseudo'] = '';
                        }

                    }
                }
            }
        }
    }
} 