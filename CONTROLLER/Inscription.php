<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 12/10/2018
 * Time: 17:45
 */

include_once 'VIEW/ViewInscription.php';
include_once 'MODEL/InscriptionBd.php';

class Inscription implements InterfaceController
{
    public function display($data = []) {
        $inscription = new ViewInscription();

        if($_SESSION['login'] === 'admin') {
            $inscription->afficherPageAdmin('Inscription');
            $this->alert($inscription);
        }
        else{
            header('location: /Accueil');

        }
        $inscription->footer();
        $inscription->end_page();
    }

    public function alert(ViewInscription $inscription){
        if ($_SESSION['statusInscription'] === 'valider') {
            $inscription->alert("Inscription réussite");
            $_SESSION['statusInscription'] = '';
        } elseif ($_SESSION['statusInscriptionMail'] === 'nonValider') {
            $inscription->alert("inscription non valide, Adresse mail déjà utilisé");
            $_SESSION['statusInscriptionMail'] = '';
        } elseif ($_SESSION['statusInscriptionPseudo'] === 'nonValider') {
            $inscription->alert("inscription non valide,Pseudo déjà utilisé");
            $_SESSION['statusInscriptionPseudo'] = '';
        }
    }

    public function inscriptionUtilisateur(){
        $bd = new InscriptionBd();

        $mail = filter_input(INPUT_POST, 'mail');
        $mdp = filter_input(INPUT_POST, 'mdp');
        $status = filter_input(INPUT_POST, 'status');
        $pseudo = filter_input(INPUT_POST, 'pseudo');
        $bd->inscrire($mail,$mdp,$status,$pseudo);

        header('location: /Inscription');
    }
}