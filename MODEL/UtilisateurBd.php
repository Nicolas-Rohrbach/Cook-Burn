<?php
/**
 * Created by PhpStorm.
 * User: a17009559
 * Date: 25/10/18
 * Time: 13:36
 */
include_once 'AbstractDB.php';
class UtilisateurBd extends AbstractDB
{
    public function recupererListDesUtilisateur(){
        $link = $this->getDbLink();
        $query = 'SELECT * FROM user';
        $list = array();

        $dbResult = mysqli_query($link, $query);
        while($dbRow = mysqli_fetch_assoc($dbResult)) {
            if ($dbRow ['status'] === 'membre'){
                $list[] = $dbRow['id'];
                $list[] = $dbRow ['mail'];
                $list[] = $dbRow ['pseudo'];
            }
        }
        return $list;
    }

    public function recupererUnUtilisateur($id){
        $link = $this->getDbLink();
        $query = 'SELECT * FROM user where id = ?';

        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);

            $dbResult = mysqli_stmt_get_result($stmt);
            $dbRow = mysqli_fetch_assoc($dbResult);
        }

        return $dbRow;
    }

    public function editerUnUtilisateur($pseudo, $mail, $id)
    {
        $link = $this->getDbLink();
        $query1 = 'SELECT * FROM user where mail = ? and id <> ? ';
        $query2 = 'SELECT * FROM user where pseudo = ? and id <> ?';
        $query3 = 'UPDATE user SET `mail`= ? ,`pseudo` = ? WHERE id = ?';

        if ($stmt = mysqli_prepare($link, $query1)) {
            mysqli_stmt_bind_param($stmt, 'si', $mail, $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $_SESSION['statusEditionUtilisateurMail'] = 'nonValider';
            } else {
                if ($stmt = mysqli_prepare($link, $query2)) {
                    mysqli_stmt_bind_param($stmt, 'si', $pseudo, $id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        $_SESSION['statusEditionUtilisateurPseudo'] = 'nonValider';
                    } else {
                        if ($stmt = mysqli_prepare($link, $query3)) {
                            mysqli_stmt_bind_param($stmt, 'ssi', $mail, $pseudo, $id);
                            mysqli_stmt_execute($stmt);

                            $_SESSION['statusEditerUtilisateur'] = 'valider';

                            $_SESSION['statusEditionUtilisateurPseudo'] = '';
                            $_SESSION['statusEditionUtilisateurMail'] = '';
                        }
                    }
                }
            }
        }
    }

    public function supprimerUnUtilisateur($id){
        $link = $this->getDbLink();
        $query = 'DELETE FROM `user` WHERE id = ?';

        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, 'i',$id[0]);
            mysqli_stmt_execute($stmt);

            $query2 = 'select * FROM `burn` WHERE idU = ?';
            if ($stmt = mysqli_prepare($link, $query2)) {
                mysqli_stmt_bind_param($stmt, 'i', $id[0]);
                mysqli_stmt_execute($stmt);

                $dbResult = mysqli_stmt_get_result($stmt);
                while ($dbRow = mysqli_fetch_assoc($dbResult)) {
                    $query3 = 'DELETE FROM `burn` WHERE idU = ?';
                    if ($stmt = mysqli_prepare($link, $query3)) {
                        mysqli_stmt_bind_param($stmt, 'i', $dbRow['idU']);
                        mysqli_stmt_execute($stmt);
                    }
                }
            }
        }
    }
}