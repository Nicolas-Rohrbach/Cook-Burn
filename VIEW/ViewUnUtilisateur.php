<?php
/**
 * Created by PhpStorm.
 * User: a17009559
 * Date: 25/10/18
 * Time: 14:12
 */

class ViewUnUtilisateur extends HtmlPage
{
    public function afficherPageAdmin($title, $utilisateur){
        $this->start_page($title);
        $this->connecter_admin(1);
        $this->afficherInformationUnUtilisateur($utilisateur);
    }
    public function afficherInformationUnUtilisateur($utilisateur){
        echo'
        <div class="carre_blanc text-center">
            <label class="text-dark"> Le nom de l\'Utilisateur </label><input type="text" name="pseudo" disabled="disabled" class="editable text-dark text-center" form="editerInformationUtilisateur" value="'.$utilisateur['pseudo'].'"/> <br>
            <label class="text-dark"> L\'adresse Email de l\'Utilisateur </label><input type="text" name="mail" disabled="disabled" class="editable text-dark text-center" form="editerInformationUtilisateur" value="'.$utilisateur['mail'].'"/><br>
		';

    }
    public function editerInformationUnUtilisateur($id){
        echo '
        <form action="/DescriptionUtilisateur/validerEditionUtilisateur/'.$id.'" method="post" id="editerInformationUtilisateur">
         <button id="editeInformationUtilisateur" type="button" onclick="test()"> Editer </button>
         <input type="password" id="mdpInformationUtilisateur" style="display: none;" name="verifMdp" placeholder="mot de passe"/>
         <button id="changeInformationUtilisateur" style="display:none" type="submit"> Valider </button> <br>
        </form>
        </div>
         <script>
               function test() {
                   var elements = document.getElementsByClassName("editable")
                   for(var i=0; i<elements.length; i++) {
                       elements[i].disabled = false;
                   }
                   document.getElementById("mdpInformationUtilisateur").style.display = "block";
                   document.getElementById("changeInformationUtilisateur").style.display = "block";
                   document.getElementById("editeInformationUtilisateur").style.display = "none";
               }
        </script>
        ';
    }

    public function supprimerUnUtilisateur($id){
        echo '
        <div class="text-center">
            <br><a href="/DescriptionUtilisateur/supprimerUnUtilisateur/'.$id .'" class="connection">Supprimer l\'Utilisateur</a><br>
        </div>
        ';
    }
}