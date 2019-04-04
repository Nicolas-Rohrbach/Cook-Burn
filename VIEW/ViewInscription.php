<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 12/10/2018
 * Time: 17:44
 */

class ViewInscription extends HtmlPage
{
    public function afficherPageAdmin($title){
        $this->start_page($title);
        $this->connecter_admin(3);
        $this->inscription();
    }

    private function inscription(){
        echo '
<h1 class="display-4"> Inscription</h1> </br>
    <div class="carre_blanc">
        <form action="/Inscription/inscriptionUtilisateur" method="POST">
        <div class="form-group text-center">
              <label class="text-dark">Pseudo</label><br>
             <input type="text" name="pseudo" placeholder="Pseudo" required/>
        </div>
        <div class="form-group text-center"> 
            <label class="text-dark"> Mot de passe </label><br>
             <input type="password" name="mdp" placeholder="mot de passe" required/>
        </div>
        <div class="form-group text-center">
            <label class="text-dark"> Adresse mail </label> <br>
             <input type="text" name="mail" placeholder="Mail" required/>
        </div>
         <div class="form-group text-center">
            <label class="text-dark">Status:</label> <br>
             <select name="status" required>
               <option>membre</option>
               <option>admin</option>
             </select>
          </div> 
          <div class="form-group text-center">
             <button class="btn btn-dark" type="submit" value="addInscription" name="action">Inscrire</button>
             </div>
        </form>
     </div>
        ';
    }
}