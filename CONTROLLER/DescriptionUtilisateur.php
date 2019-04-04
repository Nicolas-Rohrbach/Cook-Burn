<?php
/**
 * Created by PhpStorm.
 * User: a17009559
 * Date: 25/10/18
 * Time: 13:58
 */

include_once 'VIEW/ViewUnUtilisateur.php';
include_once 'MODEL/UtilisateurBd.php';

class DescriptionUtilisateur implements InterfaceController
{
    public function display($data = [])
    {

        $myUtilisateur = new ViewUnUtilisateur();
        $this->alert($myUtilisateur);

        if ($_SESSION['login'] === 'admin'){
            $utilisateur = $this->recupererUtilisateur($data[0]);
            $myUtilisateur->afficherPageAdmin('Utilisateur', $utilisateur);
            $myUtilisateur->editerInformationUnUtilisateur($data[0]);
            $myUtilisateur->supprimerUnUtilisateur($data[0]);
        }

        $myUtilisateur->footer();
        $myUtilisateur->end_page();
    }

    public function recupererUtilisateur($id){
        if ($_SESSION['login'] === 'admin'){
            $bd = new UtilisateurBd();
            return $bd->recupererUnUtilisateur($id);
        }
        else{
            header('location: /Accueil');
        }
    }

    public function supprimerUnUtilisateur($id){
        if ($_SESSION['login'] === 'admin'){
            $bd = new UtilisateurBd();
            $bd->supprimerUnUtilisateur($id);
            header('location: /Utilisateur');
        }
        else{
            header('location: /Accueil');

        }
    }

    public function validerEditionUtilisateur($data = []){

        if ($_SESSION['login'] === 'admin'){
            $verifMdp = filter_input(INPUT_POST, 'verifMdp');
            if($verifMdp === $_SESSION['mdp']){
                $_SESSION['verifMdpEditUtilisateur'] = 'valider';

                $pseudo = filter_input(INPUT_POST, 'pseudo');
                $mail = filter_input(INPUT_POST, 'mail');

                $bd = new UtilisateurBd();
                $bd->editerUnUtilisateur($pseudo, $mail, $data[0]);
            }
            else{
                $_SESSION['verifMdpEditUtilisateur'] = 'nonValider';
            }
            header('location: /DescriptionUtilisateur/display/'. $data[0]);
        }
        else{
            header('location: /Accueil');
        }

    }

    public function alert(ViewUnUtilisateur $utilisateur)
    {
        if ($_SESSION['verifMdpEditUtilisateur'] === 'valider') {
            if ($_SESSION['statusEditerUtilisateur'] === 'valider') {
                $utilisateur->alert("Edition réussite");
                $_SESSION['statusEditerUtilisateur'] = '';
            } elseif ($_SESSION['statusEditionUtilisateurMail'] === 'nonValider') {
                $utilisateur->alert("Edition non valide, Adresse mail déjà utilisé");
                $_SESSION['statusEditionUtilisateurMail'] = '';
            } elseif ($_SESSION['statusEditionUtilisateurPseudo'] === 'nonValider') {
                $utilisateur->alert("Edition non valide, Pseudo déjà utilisé");
                $_SESSION['statusEditionUtilisateurPseudo'] = '';
            }
        } elseif ($_SESSION['verifMdpEditUtilisateur'] === 'nonValider'){
            $utilisateur->alert("Mauvais mot de passe !");
            $_SESSION['verifMdpEditUtilisateur'] = '';
        }
    }

}