<?php
/**
 * Created by PhpStorm.
 * User: b17014741
 * Date: 11/10/2018
 * Time: 16:06
 */

class ViewAccueil extends HtmlPage
{

    public function afficherPageSimple($title) {
        $this->start_page($title);
        $this->non_connecter(0);
        $this->afficherDescriptionSite();
        $this->afficherLabelTopRecette();
    }


    public function afficherPageAdmin($title){
        $this->start_page($title);
        $this->connecter_admin(0);
        $this->afficherDescriptionSite();
        $this->afficherLabelTopRecette();
    }

    public function afficherPageMembre($title){
        $this->start_page($title);
        $this->connecter_membre(0);
        $this->afficherDescriptionSite();
        $this->afficherLabelTopRecette();
    }

    private function afficherDescriptionSite(){
        echo '
        <p  class="text-white text-center">Bienvenue sur le site de cuisine Cook & Burn. Vous voulez organiser un barbecue mais vous n\'avez pas d\'idée de recettes ? Envie de grillade ? de plats végétarien ?  de dessert ? Venez faire un tour sur notre site et dévouvrez notre ensemble de recettes !</p>
        ';
    }
    private function afficherLabelTopRecette(){
        echo '
            <h1 class="text-white text-center">La Recette à la une : </h1> <br>
        ';
    }
    public function afficherLabelPasDeTopRecette(){
        echo '
            <p class="text-center text-white">il n\'y a pas de recette à la une. </p> <br><br>
        ';
    }
}