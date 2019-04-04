<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 11/10/2018
 * Time: 19:21
 */
include_once 'VIEW/ViewLaRecette.php';
include_once 'CONTROLLER/Recettes.php';
include_once 'MODEL/DbRecette.php';
include_once 'MODEL/PageRecetteBd.php';

class DescriptionRecette implements InterfaceController
{
    public function display($data = []) {
        $recette = $this->recupererLaRecette($data[0]);
        $editable = $this->modifierLaRecette($data[0]);
        $etatFavori = $this->verificationEtatFavori($data[0]);
        $etatBurn = $this->verificationEtatBurn($data[0]);

        $myRecette = new ViewLaRecette();

        if ($_SESSION['login'] === 'admin'){
            $myRecette->afficherPageAdmin('recette', $recette);
        }elseif ($_SESSION['login'] === 'membre'){
            $myRecette->afficherPageMembre('recette', $recette);
        }else{
            $myRecette->afficherPageSimple('recette', $recette);
        }

        if ($etatFavori === false or $etatFavori=== 'mienne'){
            $myRecette->afficherNbBurn($recette);
        }

        if ($_SESSION['login'] === 'admin' or $_SESSION['login'] === 'membre'){
            if ($etatBurn === false){
                $myRecette->afficherLienAjouterBurn($data[0]);
            }

            if ($etatFavori === true){
                $myRecette->afficherLienSupprimerFavori($data[0]);
            }elseif ($etatFavori === false){
                $myRecette->afficherLienAjouterFavori($data[0]);
            }
            if($editable === true){
                $myRecette->editerLaRecette($data[0]);
            }
        }
        if ($_SESSION['login'] === 'admin' and ($etatFavori === false or $etatFavori === 'mienne')){
            $myRecette->afficherLiensupprimerRecette($data[0]);
        }

        $myRecette->fermerLigne();
        $myRecette->footer();
        $myRecette->end_page();
        $this->alert($myRecette);
    }

    public function recupererLaRecette($id){
        $recette = new DbRecette();
        return $recette->recupererUneRecette($id);
    }

    public function modifierLaRecette($id){
        $recette = new DbRecette();
        return $recette->editerRecette($id);
    }

    public function validerEditionRecette($data = []){
        $verifMdp = filter_input(INPUT_POST, 'verifMdp');
        if($verifMdp === $_SESSION['mdp']){

            $_SESSION['verifMdpEditRecette'] = 'valider';

            $titre = filter_input(INPUT_POST, 'titre');
            $descri = filter_input(INPUT_POST, 'descri');
            $ingre = filter_input(INPUT_POST, 'ingre');
            $prepa = filter_input(INPUT_POST, 'prepa');
            $nbPersonne = filter_input(INPUT_POST, 'nbPersonne');

            $bd = new PageRecetteBd();
            $bd->editerUneRecette($data[0],$titre, $descri, $ingre, $prepa, $nbPersonne);
        }
        else{
            $_SESSION['verifMdpEditRecette'] = 'nonValider';
        }
        header('location: /DescriptionRecette/display/'. $data[0]);
    }

    public function verificationEtatFavori($id){
        $bd = new PageRecetteBd();
        return $bd->verificationFavori($id);
    }

    public function verificationEtatBurn($id){
        $bd = new PageRecetteBd();
        return $bd->verifierBurn($id);
    }

    public function alert(ViewLaRecette $myRecette)
    {
        if ($_SESSION['verifMdpEditRecette'] === 'valider') {
            $myRecette->alert("Edition réussite");
            $_SESSION['verifMdpEditRecette'] = '';
        }
        elseif ($_SESSION['verifMdpEditRecette'] === 'nonValider'){
            $myRecette->alert("Mauvais mot de passe !");
            $_SESSION['verifMdpEditRecette'] = '';
        }
    }

    public function ajouterFavori($data = [])
    {
        $bd = new PageRecetteBd();
        $bd->ajouterAuFavori($data[0]);
        header('location: /Recettes');
    }
    public function supprimerFavori($data = [])
    {
        $bd = new PageRecetteBd();
        $bd->supprimerDesFavori($data[0]);
        header('location: /Recettes');
    }
    public function ajouterBurn($data = []){
        $bd = new PageRecetteBd();
        $bd->ajouterDesBurn($data[0]);
        header('location: /DescriptionRecette/display/' .$data[0].'');
    }
    public function supprimerRecette($data = []){
        $bd = new PageRecetteBd();
        $bd->supprimerUneRecette($data[0]);
        header('location: /Recettes');
    }
}