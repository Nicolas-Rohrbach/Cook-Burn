<?php
/**
 * Created by PhpStorm.
 * User: s17018568
 * Date: 19/10/2018
 * Time: 16:07
 */

include_once 'MODEL/BdSearch.php';
include_once 'VIEW/ViewRecette.php';

class Search implements InterfaceController
{
    public function display($data = [])
    {
        $recetteSearch = new ViewRecette();

        $mots_cles = filter_input(INPUT_POST, 'recherche');
        $action = filter_input(INPUT_POST, 'actionSearch');
        $search = new BdSearch();

        if($action === 'Rechercher')
        {
            $dbResult = $search->search($mots_cles);
            $numrow = mysqli_num_rows($dbResult);
            while($row = $dbResult->fetch_array()){
                $rows[] = $row;
            }

            if($numrow == 0){
                header("Location: Accueil");
            }
            else{
                if ($_SESSION['login'] === 'admin'){
                    $recetteSearch->afficherPageAdmin('Recette');
                }elseif ($_SESSION['login'] === 'membre'){
                    $recetteSearch->afficherPageMembre('Recette');
                }else{
                    $recetteSearch->afficherPageSimple('Recette');
                }
                $recetteSearch->afficherLesRecettes();
                $cpt = 0;
                foreach($rows as $row){
                    if($cpt == 0){
                        $recetteSearch->creerligne();
                        $recetteSearch->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                    }
                    elseif($cpt%3 == 0){
                        $recetteSearch->fermerLigne();
                        $recetteSearch->creerligne();
                        $recetteSearch->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                    }
                    else{
                        $recetteSearch->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                    }
                    $cpt++;
                }
                $recetteSearch->fermerLigne();
                $recetteSearch->fermerLigne();
                $recetteSearch->fermerLigne();

            }
        }
    }
}