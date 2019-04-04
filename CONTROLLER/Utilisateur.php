<?php
/**
 * Created by PhpStorm.
 * User: a17009559
 * Date: 25/10/18
 * Time: 13:26
 */

include_once 'VIEW/ViewUtilisateurs.php';
include_once 'MODEL/UtilisateurBd.php';
class Utilisateur implements InterfaceController
{
    public function display($data = []) {
        if ($_SESSION['login'] === 'admin'){

            $utilisateur = new ViewUtilisateurs();
            $utilisateur->afficherPageAdmin('Gestion Utilisateurs');
            $listUtilisateurs = $this->recupererToutLesUtilisateurs();
            $cpt = 0;
            for ($i = 0;$i < sizeof($listUtilisateurs); $i = $i+3){
                if($cpt == 0){
                    $utilisateur->creerligne();
                    $utilisateur->afficherMembre($listUtilisateurs[$i], $listUtilisateurs[$i+1], $listUtilisateurs[$i+2]);
                }
                elseif($cpt%3 == 0){
                    $utilisateur->fermerLigne();
                    $utilisateur->creerligne();
                    $utilisateur->afficherMembre($listUtilisateurs[$i], $listUtilisateurs[$i+1], $listUtilisateurs[$i+2]);
                }
                else{
                    $utilisateur->afficherMembre($listUtilisateurs[$i], $listUtilisateurs[$i+1], $listUtilisateurs[$i+2]);
                }
                $cpt++;
            }
        }
        else{
            header('location: /Accueil');
        }
        $utilisateur->fermerLigne();
        $utilisateur->fermerLigne();
        $utilisateur->fermerLigne();

        $utilisateur->footer();
        $utilisateur->end_page();
    }

    public function recupererToutLesUtilisateurs(){
        $bd = new UtilisateurBd();
        return $bd->recupererListDesUtilisateur();
    }
}