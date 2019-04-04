<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 15/10/2018
 * Time: 19:25
 */

include_once 'VIEW/ViewAjouterRecette.php';
include_once 'CONTROLLER/Recettes.php';
include_once 'MODEL/DbRecette.php';

class AjouterRecette implements InterfaceController
{
    public function display($data = []) {
        $ajouterRecette = new ViewAjouterRecette();

        if ($_SESSION['login'] === 'admin'){
            $ajouterRecette->afficherPageAdmin('Ajouter une recette');
        }elseif ($_SESSION['login'] === 'membre'){
            $ajouterRecette->afficherPageMembre('Ajouter une recette');
        }else{
            $ajouterRecette->afficherPageSimple('Ajouter une recette');
        }
        $ajouterRecette->footer();
        $ajouterRecette->end_page();
    }

    public function ajouterRecetteDansBd(){
        $bd = new DbRecette();

        $titre = filter_input(INPUT_POST, 'titre');
        $short_descri = filter_input(INPUT_POST, 'shortdescri');
        $descri = filter_input(INPUT_POST, 'descri');
        $ingre = filter_input(INPUT_POST, 'ingre');
        $prepa = filter_input(INPUT_POST, 'prepa');
        $nbPersonne = filter_input(INPUT_POST, 'nbPersonne');
        $image = basename($_FILES['image']['name']);
        $this->ajouterImageDossier();

        $bd->ajouterUneRecette($titre,$short_descri,$descri,$ingre,$prepa, $nbPersonne, $image);
        header('location: /Recettes');

    }
    public function ajouterImageDossier(){
        $dossier = 'VIEW/images/';

        $fichier = basename($_FILES['image']['name']);
        $taille_maxi = 10000000;
        $taille = filesize($_FILES['image']['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['image']['name'], '.');

        if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
        {
            echo 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
        }
        if($taille>$taille_maxi)
        {
            echo 'Le fichier est trop gros...';
        }
        if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
        {
            move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $fichier);//Si la fonction renvoie TRUE, c'est que ça a fonctionné..
        }
    }
}