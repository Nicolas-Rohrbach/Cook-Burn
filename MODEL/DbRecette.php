<?php

include_once 'AbstractDB.php';

class DbRecette extends AbstractDB {

    public function ajouterUneRecette($titre,$short_descri, $descri,$ingre,$prepa, $nbPersonne, $image)
    {
        $query = 'INSERT INTO recette (idU,titre,short_descri, descri, ingre, prepa, favori, nbpersonne, image) values (?,?,?,?,?,?,?,?,?)';
        $link = $this->getDbLink();

        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, 'isssssiss', $_SESSION['id'], $titre,$short_descri,$descri,$ingre,$prepa,$favori=0,$nbPersonne, $image);
            mysqli_stmt_execute($stmt);
        }
    }

    public function recupererListRecette($id = 0, $favori){
        if ($id === 0 and $favori === 0){
            $query = 'SELECT * FROM recette where favori = ?';
        }
        elseif($id === 0 and $favori === 1) {
            $query = 'SELECT * FROM recette where favori = ?';
        }
        elseif($id != 0 and $favori === 0){
            $query2 = 'SELECT * FROM recette where idU = ? and favori = ?';
        }
        elseif($id != 0 and $favori === 1){
            $query2 = 'SELECT * FROM recette where idU = ? and favori = ?';
        }

        $link = $this->getDbLink();

        if($query != NULL){
            if ($stmt = mysqli_prepare($link, $query)) {
                mysqli_stmt_bind_param($stmt, 'i',$favori);
                mysqli_stmt_execute($stmt);
            }
        }
        elseif ($query2 != NULL){
            if ($stmt = mysqli_prepare($link, $query2)) {
                mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['id'], $favori);
                mysqli_stmt_execute($stmt);
            }
        }

        $dbResult = mysqli_stmt_get_result($stmt);

        $list = array();
        while($dbRow = mysqli_fetch_assoc($dbResult)) {
            $list[] = $dbRow;
        }
        return $list;
    }

    public function recupererUneRecette($id){

        $query = 'SELECT * FROM recette where idR = ?';
        $link = $this->getDbLink();

        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, 'i',$id);
            mysqli_stmt_execute($stmt);
            $dbResult = mysqli_stmt_get_result($stmt);
            $dbRow = mysqli_fetch_assoc($dbResult);

            $query2 = 'SELECT count(*) AS NBBURN FROM `burn` WHERE idR = ? ';

            if ($stmt = mysqli_prepare($link, $query2)) {
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                $dbResult2 = mysqli_stmt_get_result($stmt);
                $dbRow2 = mysqli_fetch_assoc($dbResult2);
                $dbRow['burn'] = $dbRow2['NBBURN'];
            }
        }
        return $dbRow;
    }

    public function editerRecette($id){
        $query = 'SELECT * FROM recette where idU = ? and idR = ?';
        $link = $this->getDbLink();

        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['id'], $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function recupererRecetteQuinzBurn(){

        //$query = 'SELECT idR FROM `burn` order by idBurn desc';
        //$query2 = 'SELECT idR from burn where idR = "'.$dbRow['idR'].'" HAVING COUNT("'.$dbRow['idR'].'") > 14 ';
        $query = 'SELECT idR FROM `burn` order by idBurn desc';
        $query2 = 'SELECT idR from burn where idR = ? HAVING COUNT(?) > 14 ';

        $link = $this->getDbLink();
        $dbResult = mysqli_query($link, $query);
        while($dbRow = mysqli_fetch_assoc($dbResult)) {
            if ($stmt = mysqli_prepare($link, $query2)) {
                mysqli_stmt_bind_param($stmt, 'ii', $dbRow['idR'], $dbRow['idR']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $list = $this->recupererUneRecette($dbRow['idR']);
                    return $list;
                    break;
                }
            }
        }
        return NULL;
    }
 
    public function recupererListRecetteUtilisateurNonConnecter(){
        $query = 'SELECT idR FROM `burn` order by idBurn desc';
        $query2 = 'SELECT idR from burn where idR = ? HAVING COUNT(?) > 9 ';

        $link = $this->getDbLink();
        $list = array();
        $dbResult = mysqli_query($link, $query);
        while($dbRow = mysqli_fetch_assoc($dbResult)) {
            if ($stmt = mysqli_prepare($link, $query2)) {
                mysqli_stmt_bind_param($stmt, 'ii', $dbRow['idR'], $dbRow['idR']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $verif = false;
                    for ($i = 0; $i < sizeof($list); ++$i){
                        if (in_array($dbRow['idR'], $list[$i])){
                            $verif = true;
                        }
                    }
                    if ($verif === false){
                        $list[] = $this->recupererUneRecette($dbRow['idR']);
                    }
                }
            }
        }
        return $list;
    }
}
