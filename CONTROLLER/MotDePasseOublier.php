<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 14/10/2018
 * Time: 22:38
 */

include_once 'VIEW/ViewMotDePasseOublier.php';
include_once 'MODEL/MotDePasseOublierBd.php';

class MotDePasseOublier implements InterfaceController
{
    public function display($data = []) {
        $motDePasseOublier = new ViewMotDePasseOublier();

        $this->alert($motDePasseOublier);

        $motDePasseOublier->afficherPage('Mot de passe oublier');
        $motDePasseOublier->footer();
        $motDePasseOublier->end_page();
    }

    public function alert(ViewMotDePasseOublier $motDePasseOublier){
        if ($_SESSION['mailSendMail'] === 'nonVerifier'){
            $motDePasseOublier->alert("L'adresse mail n'existe pas !");
        }
        elseif($_SESSION['mailSendMail'] === 'verifier'){
            $motDePasseOublier->alert("Mail envoyé !");
        }
        $_SESSION['mailSendMail'] = '';
    }

    public function envoyerMail(){
        $bd = new MotDePasseOublierBd();

        $mail = filter_input(INPUT_POST, 'adrrMail');
        $bd->envoyerInformationMdp($mail);

        header('location: /MotDePasseOublier');
    }
}