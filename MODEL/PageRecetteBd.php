<?php
/**
 * Created by PhpStorm.
 * User: a17009559
 * Date: 18/10/18
 * Time: 15:15
 */

include_once 'MODEL/AbstractDB.php';
class PageRecetteBd extends AbstractDB
{
    public function editerUneRecette($id,$titre,$descri, $ingre, $prepa, $nbPersonne){
        $query = 'UPDATE recette SET `idU`= ? ,`titre`= ? ,`descri` = ?, `ingre` = ?, `prepa` = ?, `nbpersonne` = ? WHERE idR = ?';
        $link = $this->getDbLink();

        if ($stmt = mysqli_prepare($link, $query)){
            mysqli_stmt_bind_param($stmt,'isssssi', $_SESSION['id'], $titre, $descri,$ingre,$prepa,$nbPersonne, $id);
            mysqli_stmt_execute($stmt);
        }
    }

    public function verificationFavori($id)
    {
        $link = $this->getDbLink();
        $query1 = 'SELECT * FROM recette where idR = ? and idU = ? and favori = ?';
        $query2 = 'SELECT * FROM recette where idR = ? and idU <> ? and favori = ?';
        $query3 = 'SELECT * FROM recette where idR = ? and idU = ? and favori = ?';

        if ($stmt = mysqli_prepare($link, $query1)) {
            mysqli_stmt_bind_param($stmt, 'iii', $id, $_SESSION['id'], $favori = 0);
            mysqli_stmt_execute($stmt);
            $dbResult = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($dbResult) > 0) {
                return 'mienne';
            } else {
                if ($stmt = mysqli_prepare($link, $query2)) {
                    mysqli_stmt_bind_param($stmt, 'iii', $id, $_SESSION['id'], $favori = 0);
                    mysqli_stmt_execute($stmt);
                    $dbResult = mysqli_stmt_get_result($stmt);
                    if (mysqli_num_rows($dbResult) > 0) {
                        return false;
                    } else {
                        if ($stmt = mysqli_prepare($link, $query3)) {
                            mysqli_stmt_bind_param($stmt, 'iii', $id, $_SESSION['id'], $favori = 1);
                            mysqli_stmt_execute($stmt);
                            $dbResult = mysqli_stmt_get_result($stmt);
                            if (mysqli_num_rows($dbResult) > 0) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
    }

    public function ajouterAuFavori($id)
    {
        $link = $this->getDbLink();
        $query = 'SELECT * FROM recette where idR = ?';

        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
            $dbResult = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($dbResult) > 0) {
                $dbRow = mysqli_fetch_assoc($dbResult);
                $query2 = 'INSERT INTO recette (idU,titre,short_descri, descri, ingre, prepa, favori, nbpersonne, image) values (?,?,?,?,?,?,?,?,?)';
                if ($stmt2 = mysqli_prepare($link, $query2)) {
                    mysqli_stmt_bind_param($stmt2, 'isssssiss', $_SESSION['id'],$dbRow ['titre'],$dbRow ['short_descri'],$dbRow ['descri'],$dbRow ['ingre'],$dbRow['prepa'],$favori=1,$dbRow['nbpersonne'], $dbRow ['image']);
                    mysqli_stmt_execute($stmt2);
                }
            }
        }
    }

    public function supprimerDesFavori($id){
        $link = $this->getDbLink();
        $query = 'DELETE FROM `recette` WHERE idR = ? and idU = ? and favori = ?';
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, 'iii', $id, $_SESSION['id'], $favori=1);
            mysqli_stmt_execute($stmt);
        }
    }

    public function verifierBurn($id)
    {
        $link = $this->getDbLink();
        $query1 = 'SELECT * FROM recette where idR = ? and idU = ? and favori = ?';
        $query2 = 'SELECT * FROM burn where idR = ? and idU = ?';
        $query3 = 'SELECT * FROM recette where idR = ? and idU <> ? and favori = ?';
        $query4 = 'SELECT * FROM burn where idR = ? and idU = ?';

        if ($stmt = mysqli_prepare($link, $query1)) {
            mysqli_stmt_bind_param($stmt, 'iii', $id, $_SESSION['id'], $favori = 0);
            mysqli_stmt_execute($stmt);
            $dbResult = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($dbResult) > 0) {
                if ($stmt = mysqli_prepare($link, $query2)) {
                    mysqli_stmt_bind_param($stmt, 'ii', $id, $_SESSION['id']);
                    mysqli_stmt_execute($stmt);
                    $dbResult = mysqli_stmt_get_result($stmt);
                    if (mysqli_num_rows($dbResult) > 0) {
                        return 'dejaBurner';
                    } else {
                        return false;
                    }
                }
            } else {
                if ($stmt = mysqli_prepare($link, $query3)) {
                    mysqli_stmt_bind_param($stmt, 'iii', $id, $_SESSION['id'], $favori = 0);
                    mysqli_stmt_execute($stmt);
                    $dbResult = mysqli_stmt_get_result($stmt);
                    if (mysqli_num_rows($dbResult) > 0) {
                        if ($stmt = mysqli_prepare($link, $query4)) {
                            mysqli_stmt_bind_param($stmt, 'ii', $id, $_SESSION['id']);
                            mysqli_stmt_execute($stmt);
                            $dbResult = mysqli_stmt_get_result($stmt);
                            if (mysqli_num_rows($dbResult) > 0) {
                                return 'dejaBurner';
                            } else {
                                return false;
                            }
                        }
                    }
                }
            }
        }
        return true;
    }

    public function ajouterDesBurn($id)
    {
        $link = $this->getDbLink();
        $query1 = 'INSERT INTO `burn`(`idR`, `idU`) VALUES (?,?)';
        if ($stmt = mysqli_prepare($link, $query1)) {
            mysqli_stmt_bind_param($stmt, 'ii', $id, $_SESSION['id']);
            mysqli_stmt_execute($stmt);
        }
    }

    public function supprimerUneRecette($id)
    {
        $link = $this->getDbLink();
        $query = 'DELETE FROM `recette` WHERE idR = ?';

        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);
        }

        $query2 = 'select * FROM `burn` WHERE idR = ?';
        if ($stmt = mysqli_prepare($link, $query2)) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            mysqli_stmt_execute($stmt);

            $dbResult = mysqli_stmt_get_result($stmt);
            while ($dbRow = mysqli_fetch_assoc($dbResult)) {
                $query3 = 'DELETE FROM `burn` WHERE idR = ?';
                if ($stmt = mysqli_prepare($link, $query3)) {
                    mysqli_stmt_bind_param($stmt, 'i', $dbRow['idR']);
                    mysqli_stmt_execute($stmt);
                }
            }

        }
    }

}