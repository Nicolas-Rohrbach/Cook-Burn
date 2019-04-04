<?php
/**
 * Created by PhpStorm.
 * User: fmgsnape
 * Date: 14/10/2018
 * Time: 22:41
 */
include_once 'AbstractDB.php';

class MotDePasseOublierBd extends AbstractDB
{
    public function envoyerInformationMdp($mail){
        $query = 'SELECT * FROM user where mail = ?';
        $link = $this->getDbLink();
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt, 's', $mail);
            mysqli_stmt_execute($stmt);
            $dbResult = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($dbResult) > 0) {
                $dbRow = mysqli_fetch_assoc($dbResult);

                $to = $mail;
                $subject = 'le sujet';
                $message = 'Votre mot de passe est : ' . $dbRow ['pass'];;
                $headers = 'From: webmaster@example.com' . "\r\n" .
                    'Reply-To: webmaster@example.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail($to, $subject, $message, $headers);

                $_SESSION['mailSendMail'] = 'verifier';
            } else {
                $_SESSION['mailSendMail'] = 'nonVerifier';
            }
        }
    }
}