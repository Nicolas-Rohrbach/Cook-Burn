<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 11/10/2018
 * Time: 22:33
 */

class ViewLaRecette extends HtmlPage
{


    public function afficherPageSimple($title,$recette) {
        $this->start_page($title);
        $this->non_connecter(1);
        $this->afficherLaRecette($recette);
    }

    public function afficherPageAdmin($title, $recette){
        $this->start_page($title);
        $this->connecter_admin(1);
        $this->afficherLaRecette($recette);
    }

    public function afficherPageMembre($title,$recette){
        $this->start_page($title);
        $this->connecter_membre(1);
        $this->afficherLaRecette($recette);
    }

    private function afficherLaRecette($recette){
        echo' 
        <div class="carre_blanc_grand text-center"> 
            <img src="/VIEW/images/'.$recette['image'].'"/><br>
            <label> Titre </label> <br><textarea type="text" name="titre" disabled="true" class="editable text-justify" form="editerRecette" >'.$recette['titre'].'</textarea> <br>
            <label class="texte"> Nombre de convive(s) : </label><input id="texte" type="text" name="nbPersonne" disabled="true" class="editable text-justify" form="editerRecette" value="'.$recette['nbpersonne'].'"/><br>
            <label> Description  </label> <br> <textarea cols="50" rows="8" id="texta" name="descri" disabled="true" class="editable text-justify"  form="editerRecette" >'.$recette['descri'].'</textarea> <br>
            <label> Ingredients  </label> <br> <textarea cols="50" rows="8" id="texta" name="ingre" disabled="true" class="editable text-justify" form="editerRecette" >'.$recette['ingre'].'</textarea> <br>
            <label> Préparation  </label> <br> <textarea cols="50" rows="8" id="texta" name="prepa" disabled="true" class="editable text-justify" form="editerRecette" >'.$recette['prepa'].'</textarea> <br>

		';
    }

    public function editerLaRecette($id){
        echo '
        <form action="/DescriptionRecette/validerEditionRecette/'.$id.'" method="post" id="editerRecette">
         <button id="editeLaRecette" type="button" onclick="test2()"> Editer </button>
         <input type="password" id="mdpLaRecette" style="display: none;" name="verifMdp" placeholder="mot de passe"/>
         <button id="changeLaRecette" style="display:none" type="submit"> Valider </button> <br>
        </form>
         <script>
               function test2() {
                   var elements = document.getElementsByClassName("editable");
                   for(var i=0; i<elements.length; i++) {
                       elements[i].disabled = false;
                   }
                   document.getElementById("mdpLaRecette").style.display = "block";
                   document.getElementById("changeLaRecette").style.display = "block";
                   document.getElementById("editeLaRecette").style.display = "none";
                }
    </script>
        ';
    }

    public function afficherNbBurn($recette){
        echo ' 
        <img src="/icone.png" width="30" height="30">' . $recette['burn'] .'<br> 
        ';
    }

    public function afficherLienAjouterFavori($id){
        echo '
           <a href="/DescriptionRecette/ajouterFavori/'.$id.'" class="connection"> Ajouter aux Favoris </a>
        ';
    }
    public function afficherLienSupprimerFavori($id){
        echo '
           <br><a href="/DescriptionRecette/supprimerFavori/'.$id.'" class="connection"> Supprimer des Favoris </a><br>   
        ';
    }
    public function afficherLienAjouterBurn($id){
        echo '
           <a href="/DescriptionRecette/ajouterBurn/'.$id.'" class="connection"> Ajouter un Burn </a>                   
        ';
    }
    public function afficherLiensupprimerRecette($id){
        echo '
            <a href="/DescriptionRecette/supprimerRecette/'.$id.'" class="connection"> Supprimer la recette </a> <br>
        ';
    }

}
