<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 12/10/2018
 * Time: 20:38
 */

include_once 'VIEW/ViewMonCompte.php';
include_once 'MODEL/DbRecette.php';
include_once 'MODEL/EditerCompteBd.php';
include_once  'VIEW/ViewRecette.php';


class MonCompte implements InterfaceController
{
    public function display($data = [])
    {

        $monCompte = new ViewMonCompte();
        $recette = new DbRecette();
        $mesRecettesCreees = new ViewRecette();

        if ($_SESSION['login'] === 'admin') {
            $monCompte->afficherPageAdmin('Mon compte');
        }
        if ($_SESSION['login'] === 'membre') {
            $monCompte->afficherPageMembre('Mon compte');
        }

        if ($_SESSION['login'] === 'admin' or $_SESSION['login'] === 'membre'){
            $mesRecettes = $recette->recupererListRecette($_SESSION['id'], 0);
            $mesRecettesFavorite = $recette->recupererListRecette($_SESSION['id'], 1);
            $cpt=0;
            foreach ($mesRecettes as $row){

                if($cpt == 0){
                    $mesRecettesCreees->creerligne();
                    $mesRecettesCreees->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                elseif($cpt%3 == 0){
                    $mesRecettesCreees->fermerLigne();
                    $mesRecettesCreees->creerligne();
                    $mesRecettesCreees->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                else{
                    $mesRecettesCreees->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                $cpt++;
            }

            $monCompte->fermerLigne();
            $monCompte->fermerLigne();
            $monCompte->fermerLigne();

            $mesRecettesCreees->afficherLesFavori();
            $cpt = 0;
            foreach ($mesRecettesFavorite as $row) {
                if($cpt == 0){
                    $monCompte->creerligne();
                    $monCompte->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                elseif($cpt%3 == 0){
                    $monCompte->fermerLigne();
                    $monCompte->creerligne();
                    $monCompte->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                else{
                    $monCompte->afficherRecette($row['idR'],$row['titre'], $row['short_descri'], $row['image']);
                }
                $cpt++;
            }
            $monCompte->fermerLigne();
            $monCompte->fermerLigne();
            $monCompte->fermerLigne();

            $monCompte->footer();
            $monCompte->end_page();
            $this->alert($monCompte);
        }
        else{
            header('location: /Accueil');

        }
    }

    public function alert(ViewMonCompte $monCompte){
        if ($_SESSION['verifMdpEditCompte'] === '') {
            if ($_SESSION['statusEditerCompte'] === 'valider') {
                $monCompte->alert("Edition réussite");
                $_SESSION['statusEditerCompte'] = '';
            } elseif ($_SESSION['statusEditionCompteMail'] === 'nonValider') {
                $monCompte->alert("Edition non valide, Adresse mail déjà utilisé");
                $_SESSION['statusEditionCompteMail'] = '';
            } elseif ($_SESSION['statusEditionComptePseudo'] === 'nonValider') {
                $monCompte->alert("Edition non valide, Pseudo déjà utilisé");
                $_SESSION['statusEditionComptePseudo'] = '';
            }
        } elseif ($_SESSION['verifMdpEditCompte'] === 'nonValider'){
            $monCompte->alert("Mauvais mot de passe !");
            $_SESSION['verifMdpEditCompte'] = '';
        }
    }

    public function editerInformationCompte(){
        $bd = new EditerCompteBd();

        $verifMdp = filter_input(INPUT_POST, 'verifMdp');

        if($verifMdp === $_SESSION['mdp']){
            $_SESSION['verifMdpEditCompte'] = '';

            $mail = filter_input(INPUT_POST, 'mail');
            $mdp = filter_input(INPUT_POST, 'mdp');
            $pseudo = filter_input(INPUT_POST, 'pseudo');
            $bd->editerCompte($mail,$mdp,$pseudo);
        }
        else{
            $_SESSION['verifMdpEditCompte'] = 'nonValider';
        }
        header('location: /MonCompte');
    }
}