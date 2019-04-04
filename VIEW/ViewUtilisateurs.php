<?php
/**
 * Created by PhpStorm.
 * User: a17009559
 * Date: 25/10/18
 * Time: 13:27
 */

class ViewUtilisateurs extends HtmlPage
{
    public function afficherPageAdmin($title){
        $this->start_page($title);
        $this->connecter_admin(0);
        $this->ajouterUtilisateur();
        $this->carrerblanc();
        $this->afficherTitreDeAfficherMembre();
        $this->affichageParTrois();
    }

    public function afficherMembre($id, $mail, $pseudo){
        echo '
        <div class = "col-sm-4">
        <br><a href="/DescriptionUtilisateur/display/'.$id .'" class="btn btn-success">'.$pseudo.'</a><br>
        </div>
        ';
    }

    private function ajouterUtilisateur(){
        echo '
        <h2 class="text-center text-white"> Ajouter un Utilisateur : <a href="/Inscription" class="connection"> Inscription </a></h2><br>
        ';
    }

    private function afficherTitreDeAfficherMembre(){
        echo'<h3 class="text-black-50 text-center">Choisir le pseudo a modifier/supprimer</h3>';
    }

}