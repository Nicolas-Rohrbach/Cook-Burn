<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 14/10/2018
 * Time: 22:39
 */

class ViewMotDePasseOublier extends HtmlPage
{

    public function afficherPage($string)
    {
        $this->start_page($string);

        $this->non_connecter(3);
        $this->afficherFormulaireMdpOublier();
    }

    public function afficherFormulaireMdpOublier(){
        echo '
        <form action="/MotDePasseOublier/envoyerMail" method="post">
            <input type="text" name="adrrMail" placeholder="adresse mail..." required>
            <button type="submit">Envoyer</button>
        </form>
        ';
    }
}