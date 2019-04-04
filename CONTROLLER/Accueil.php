<?php
/**
 * Created by PhpStorm.
 * User: b17014741
 * Date: 11/10/2018
 * Time: 16:30
 */

include_once 'VIEW/ViewAccueil.php';
include_once 'CONTROLLER/Recettes.php';

class Accueil implements InterfaceController
{
    public function display($data = []) {
        $accueil = new ViewAccueil();
        $recetteUne = new ViewRecette();
        $recette = new Recettes();


        if ($_SESSION['login'] === 'admin'){
            $accueil->afficherPageAdmin('Accueil');
        }elseif ($_SESSION['login'] === 'membre'){
            $accueil->afficherPageMembre('Accueil');
        }else{
            $accueil->afficherPageSimple('Accueil');
        }



        $recetteALaUne = $recette->recupererMeilleurRecette();
        if ($recetteALaUne != false) {
            $recetteUne->afficerRecetteALaUne();
            $recetteUne->afficherRecette($recetteALaUne['idR'], $recetteALaUne['titre'], $recetteALaUne['short_descri'], $recetteALaUne['image']);
        }
        else
            $accueil->afficherLabelPasDeTopRecette();
        $recetteUne->fermerLigne();
        $recetteUne->fermerLigne();
        $accueil->footer();
        $accueil->end_page();
    }
}