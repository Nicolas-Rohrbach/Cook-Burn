<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 11/10/2018
 * Time: 19:21
 */

include_once 'VIEW/ViewRecette.php';
include_once 'MODEL/DbRecette.php';


class Recettes implements InterfaceController
{
    public function display($data = []) {

        $recette = new ViewRecette();

        if ($_SESSION['login'] === 'admin'){
            $recette->afficherPageAdmin('Recette');
        }elseif ($_SESSION['login'] === 'membre'){
            $recette->afficherPageMembre('Recette');
        }else{
            $recette->afficherPageSimple('Recette');
        }
        if ($_SESSION['login'] === 'admin' or $_SESSION['login'] === 'membre'){
            $myListRecette = $this->recupererListRecette();
            $recette->afficherLesRecettes();
            $cpt = 0;
            foreach ($myListRecette as $row) {
                if($cpt == 0){
                    $recette->creerligne();
                    $recette->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                elseif($cpt%3 == 0){
                    $recette->fermerLigne();
                    $recette->creerligne();
                    $recette->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                else{
                    $recette->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                $cpt++;
            }
            $recette->fermerLigne();
            $recette->fermerLigne();
            $recette->fermerLigne();

            $mesFavoris = $this->recupererListFavori();
            $recette->afficherLesFavori();
            $cpt = 0;
            foreach ($mesFavoris as $row) {
                if($cpt == 0){
                    $recette->creerligne();
                    $recette->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                elseif($cpt%3 == 0){
                    $recette->fermerLigne();
                    $recette->creerligne();
                    $recette->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                else{
                    $recette->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                $cpt++;
            }

            $recette->fermerLigne();
            $recette->fermerLigne();
            $recette->fermerLigne();
        }
        else{
            $myListRecetteNonConnecter = $this->recupererListRecetteNonConnecter();
            $recette->afficherLesRecettes();
            $cpt = 0;
            for ($i = 0;$i < sizeof($myListRecetteNonConnecter); $i = $i+1){
                if($cpt == 0){
                    $recette->creerligne();
                    $recette->afficherRecette($myListRecetteNonConnecter[$i]['idR'], $myListRecetteNonConnecter[$i]['titre'], $myListRecetteNonConnecter[$i]['short_descri'],$myListRecetteNonConnecter[$i]['image']);
                }
                elseif($cpt%3 == 0){
                    $recette->fermerLigne();
                    $recette->creerligne();
                    $recette->afficherRecette($myListRecetteNonConnecter[$i]['idR'], $myListRecetteNonConnecter[$i]['titre'], $myListRecetteNonConnecter[$i]['short_descri'],$myListRecetteNonConnecter[$i]['image']);
                }
                else{
                    $recette->afficherRecette($myListRecetteNonConnecter[$i]['idR'], $myListRecetteNonConnecter[$i]['titre'], $myListRecetteNonConnecter[$i]['short_descri'],$myListRecetteNonConnecter[$i]['image']);
                }
                ++$cpt;
            }
            $recette->fermerLigne();
            $recette->fermerLigne();
            $recette->fermerLigne();
        }

        $recette->footer();
        $recette->end_page();
    }

    public function recupererListRecette(){
        $recette = new DbRecette();
        return $recette->recupererListRecette(0,0);
    }
    public function recupererListRecetteNonConnecter(){
        $recette = new DbRecette();
        return $recette->recupererListRecetteUtilisateurNonConnecter();
    }
    public function recupererListFavori()
    {
        $recette = new DbRecette();
        return $recette->recupererListRecette($_SESSION['id'],1);
    } 
    public function recupererMeilleurRecette(){
        $recette = new DbRecette();
        return $recette->recupererRecetteQuinzBurn();
    }
}