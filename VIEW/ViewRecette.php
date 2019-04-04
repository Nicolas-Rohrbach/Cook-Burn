<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 11/10/2018
 * Time: 22:33
 */

class ViewRecette extends HtmlPage
{
    public function afficherPageSimple($title) {
        $this->start_page($title);
        $this->non_connecter(1);
    }

    public function afficherPageAdmin($title){
        $this->start_page($title);
        $this->connecter_admin(1);
    }

    public function afficherPageMembre($title){
        $this->start_page($title);
        $this->connecter_membre(1);
    }

    public function afficherLesRecettes(){
        $this->carrerblanc();
        $this->afficherLabelRecette();
        $this->affichageParTrois();
    }
    public function afficherLesFavori(){
        $this->carrerblanc();
        $this->afficherMesFavori();
        $this->affichageParTrois();
    }

    public function afficerRecetteALaUne(){
        $this->carrerblanc();
        $this->affichageParTrois();
    }

    private function afficherLabelRecette(){
        echo '
            <h2 class="text-center text-black">Liste des recettes</h2> <br>
        ';
    }
}