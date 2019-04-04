<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 12/10/2018
 * Time: 20:30
 */

class ViewMonCompte extends HtmlPage
{
    public function afficherPageAdmin($title){
        $this->start_page($title);
        $this->connecter_admin(3);
        $this->afficherInformationCompte();
        $this->editerInformationCompte();
        $this->carrerblanc();
        $this->afficherMesRecettesCompte();
        $this->affichageParTrois();

    }
    public function afficherPageMembre($title){
        $this->start_page($title);
        $this->connecter_membre(3);
        $this->afficherInformationCompte();
        $this->editerInformationCompte();
        $this->carrerblanc();
        $this->afficherMesRecettesCompte();
        $this->affichageParTrois();
    }

    public function afficherInformationCompte(){
        echo'
        <div class="carre_blanc text-center">
            <label class="text-dark">Votre pseudo est :  </label> <input form="editerInformationCompte" type="text" class="editable text-dark text-center" disabled="true" name ="pseudo" value="'; echo $_SESSION['pseudo']; echo '" required> </input><br>
            <label class="text-dark">Votre mot de passe est :  </label> <input form="editerInformationCompte" type="password" class="editable text-dark text-center" disabled="true" name ="mdp"  value="'; echo $_SESSION['mdp']; echo '" required> </input><br>
            <label class="text-dark">Votre adresse mail est :  </label> <input form="editerInformationCompte" type="text" class="editable text-dark text-center" disabled="true" name ="mail" value="'; echo $_SESSION['mail']; echo '" required></input><br>
            <label class="text-dark">Votre statut est :  </label> <input type="text" id="nonEditable text-dark text-center" disabled="true" value="'; echo $_SESSION['login']; echo '"></input><br>
        
        ';
    }
    public function editerInformationCompte(){
        echo '
        <form action="/MonCompte/EditerInformationCompte" method="post" id="editerInformationCompte">
         <button id="editeInformationCompte" type="button" onclick="test()"> Editer </button>
         <input type="password" id="mdpInformationCompte" style="display: none;" name="verifMdp" placeholder="mot de passe"/>
         <button id="changeInformationCompte" style="display:none" type="submit"> Valider </button> <br>
        </form>
        </div>
         <script>
               function test() {
                   var elements = document.getElementsByClassName("editable");
                   for(var i=0; i<elements.length; i++) {
                       elements[i].disabled = false;
                   }
                   document.getElementById("mdpInformationCompte").style.display = "block";
                   document.getElementById("changeInformationCompte").style.display = "block";
                   document.getElementById("editeInformationCompte").style.display = "none";
                }
        </script>
        ';
    }

    public function afficherMesRecettesCompte(){
        echo ' 
        <br><br> 
        <p class="text-dark">Ajouter une Recette : </p> <br>
        <a href="/AjouterRecette" class="connection"> Ajouter une Recette </a><br><br>
        <h3 class="text-center text-dark">Mes Recettes : </h3><br>
        ';
    }
}