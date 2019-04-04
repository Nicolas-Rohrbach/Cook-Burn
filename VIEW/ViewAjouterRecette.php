<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 15/10/2018
 * Time: 19:02
 */

class ViewAjouterRecette extends HtmlPage
{
    public function afficherPageSimple($title) {
        $this->start_page($title);
        $this->non_connecter(1);
    }

    public function afficherPageAdmin($title){
        $this->start_page($title);
        $this->connecter_admin(1);
        $this->ajouterRecette();
    }

    public function afficherPageMembre($title){
        $this->start_page($title);
        $this->connecter_membre(1);
        $this->ajouterRecette();
    }

    private function ajouterRecette(){
        echo '
         <div class="carre_blanc text-center">
        <form action="/AjouterRecette/ajouterRecetteDansBd" method="post" enctype="multipart/form-data">
            <label> Photo : </label><br>
            <img id="output_image"/>
            <input accept="images/*" onchange="preview_image(event)" type="file" name="image" required/>
            <script type=\'text/javascript\'>
                function preview_image(event){
                    var reader = new FileReader();
                    reader.onload = function() {
                        var output = document.getElementById(\'output_image\');
                        output.src = reader.result;
                    }
                    reader.readAsDataURL(event.target.files[0]);
                } 
            </script>
            <label> Titre de la recette : </label><br> <input type="text" name="titre" required/> <br>
            <label> Nombre de personnes : </label><br> <input type="text" name="nbPersonne" required/> <br>
            <label> Description courte :  </label> <br> <textarea name="shortdescri" required></textarea> <br>
            <label> Description :  </label> <br> <textarea name="descri" required></textarea> <br>
            <label> Ingredients :  </label> <br> <textarea name="ingre" required></textarea> <br>
            <label> Préparation :  </label> <br> <textarea name="prepa" required></textarea> <br>
            <button type="submit" class="btn-dark">Ajouter Recette</button>
        </form>
        </div>
        ';
    }
}