<?php
/**
 * Created by PhpStorm.
 * User: b17014741
 * Date: 11/10/2018
 * Time: 16:36
 */

abstract class HtmlPage
{
    public function start_page($title){
        echo ' <!DOCTYPE html>
           <html lang="fr">
                <head>
                    <title>' . PHP_EOL . $title . '</title>
                    <meta charset="utf-8"/>
                  
                    <link  type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                    <link  type="text/css" rel="stylesheet" href="/../VIEW/CSS/style.css">
                     
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

                    <link rel="icon" type="image/png" href="icone.png" /> 
                </head>
                <body>
  
                 ' . PHP_EOL;
    }


    public function non_connecter($var){
        echo ' 
              <nav class="navbar navbar-dark bg-dark">
                    <a class="navbar-brand" href="/Accueil">
                        <img src="/icone.png" width="30" height="30" class="d-inline-block align-top" alt="icone"> Cook & Burn
                    </a>
                    <a class="navbar-brand" href="/Recettes">Recette <span class="sr-only">(current)</span></a>
                      
                  <a class="navbar-brand" href="/MotDePasseOublier"> Mot de passe oublié </a>

                  <form class="form-inline my-2 my-lg-0"  action="/BaseDeDonnee/connection" method="POST">
                    <input type="text" name="login" placeholder="Mail ou Pseudo" required/>
                    <input type="password" name="mdp" placeholder="mot de passe" required/>
                    <button class="btn btn-sm btn-outline-secondary" type="submit">Connecter</button>
                  </form>
                  
                  <form class ="form-inline my-2 my-lg-0" method="POST" action="/Search">
                    <input name ="recherche" type="text" class="form-control mr-sm-2" placeholder="Recherche..." required/>
                    <button class="btn btn-sm btn-outline-secondary"  name = "actionSearch" value="Rechercher" type="submit" >Recherche</button> 
                  </form>
              </nav>
              <br>
            <script> 
                    var test = document.getElementsByClassName("list")
                    var current = document.getElementsByClassName("active")
                    current[0].className = current[0].className.replace(" active", "")
                    test['.$var.'].className += " active"
            </script>';
    }

    public function connecter_admin($var){
        echo '<nav class="navbar navbar-dark bg-dark"> 
                    <a class="navbar-brand" href="/Accueil">
                        <img src="/icone.png" width="30" height="30" class="d-inline-block align-top" alt="icone"> Cook & Burn
                    </a>
                    <a class="navbar-brand" href="/Recettes">Recette <span class="sr-only">(current)</span></a>
                
                 <a class="navbar-brand" href="/Utilisateur">Utilisateur</a>
                 <a class="navbar-brand" href="/MonCompte">Mon Compte </a>
                 <a class="navbar-brand" href="/BaseDeDonnee/deconnection"> Deconnexion </a>

                 

                  <label class="text-light navbar-brand">Connecté(e) en tant que : '; echo $_SESSION['pseudo']; echo '</label>
                  
                  <form class ="form-inline my-2 my-lg-0" method="POST" action="/Search">
                   <input name ="recherche" type="text" class="form-control mr-sm-2" placeholder="Recherche..." required/>
                    <button class="btn btn-sm btn-outline-secondary" name = "actionSearch" value="Rechercher">Recherche</button> 
                  </form>
             </nav>
            <script>
                    var test = document.getElementsByClassName("list")
                    var current = document.getElementsByClassName("active")
                    current[0].className = current[0].className.replace(" active", "")
                    test['.$var.'].className += " active"
            </script>';


    }
    public function connecter_membre($var){
        echo '<nav class="navbar navbar-dark bg-dark"> 
                    <a class="navbar-brand" href="/Accueil">
                        <img src="/icone.png" width="30" height="30" class="d-inline-block align-top" alt="icone"> Cook & Burn
                    </a>
                    <a class="navbar-brand" href="/Recettes">Recette <span class="sr-only">(current)</span></a>                  
                  
                  <a class="navbar-brand" href="/MonCompte">Mon Compte </a>         
                  <a class="navbar-brand" href="/BaseDeDonnee/deconnection" class="connection"> Deconnexion </a>
                  
                  <label class="text-light navbar-brand">Connecté(e) en tant que : '; echo $_SESSION['pseudo']; echo '</label>
                  
                  <form class ="form-inline my-2 my-lg-0" method="POST" action="/Search">
                    <input name ="recherche" type="text" class="form-control mr-sm-2" placeholder="Recherche..." required/>
                    <button class="btn btn-sm btn-outline-secondary" name = "actionSearch" value="Rechercher">Recherche</button> 
                  </form>
              </nav>
            <script>
                    var test = document.getElementsByClassName("list")
                    var current = document.getElementsByClassName("active")
                    current[0].className = current[0].className.replace(" active", "")
                    test['.$var.'].className += " active"
            </script>';
    }

    public function afficherRecette($id, $titre,$short_descri, $image){
        echo '
        <div class = "col-sm-4">
            <div class="card text-white bg-dark" style="max-width: 18rem;">
                <img class="card-img-top" src="/VIEW/images/'.$image.'" alt="Recette">
                <div class="card-body text-center">
                    <h5 class="card-title font-weight-bold">'.$titre.'</h5>
                    <p class="card-text font-italic">'.$short_descri.'</p>
                    <a class="btn btn-primary card-"  href="/DescriptionRecette/display/'.$id.'">Voir la recette</a> 
                </div>
            </div>
        </div>
        ';

    }


    public function carrerblanc() {
        echo '<div class="carre_blanc_grand text-center">';
    }

    public function affichageParTrois(){
        echo'<div class="container">
              ';
    }

    public function creerligne(){
        echo '<div class="row form-group"><br>';
    }

    public function fermerLigne(){
        echo '</div>';
    }

    public function afficherMesFavori(){
        echo '
        <h4 class="text-center text-black">Mes Favoris :</h4><br>
        ';
    }

    function alert($msg) {
        echo '<script type=\'text/javascript\'>alert("'. $msg .'");</script>';
    }

    public function end_page() {
        echo '
         </body>

        </html>';
    }

    public function footer(){
        echo'<footer class="page-footer bg-dark">
            <div class="container form-inline">
             <form class ="form-inline my-2 my-lg-0" method="POST" action="/Accueil">
                <button class="btn btn-sm btn-outline-secondary" name="theme" value="Halloween" type="submit">Thème Halloween</button>    
             </form> 
              <form class ="form-inline my-2 my-lg-0" method="POST" action="/Accueil">
                <button class="btn btn-sm btn-outline-secondary" name="disableTheme" value="unHalloween" type="submit">Thème Normal</button>    
             </form> 
                <div class="footer-copyright text-center py-3 text-white">© 2018 Copyright:
                    <a href="https://iut.univ-amu.fr/diplomes/dut-informatique">IUT Info Aix</a>
                </div>  
             </div>
         </footer>';
    }
}
