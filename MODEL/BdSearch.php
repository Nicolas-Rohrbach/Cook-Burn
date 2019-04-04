<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 19/10/2018
 * Time: 15:14
 */
include_once 'AbstractDB.php';

class BdSearch extends AbstractDB
{
    public function search($chaine)
    {
        $cpt = 0;
        $lenstring = strlen($chaine);
        $unMot = '';
    for ($i=0; $i < $lenstring ; $i++)
    {
        if($chaine[$i] == ' '){
            $unMot = '';
            $cpt++;
        }
        else{
            $unMot .= $chaine[$i];
            $mots_cles[$cpt] = $unMot;
        }
    }
        $query = 'SELECT * FROM recette WHERE';
        foreach ($mots_cles as $mot_cle){
           $query.= ' titre LIKE \''. '%' . $mot_cle . '%' .'\' or descri LIKE \'' . '%' . $mot_cle . '%' . '\' or ingre LIKE \'' . '%' . $mot_cle. '%' .'\' or';
        }
        $query .= ' 1 = 0;';
        $dbResult = mysqli_query($this->getDbLink(), $query);
        return $dbResult;

    }

}
