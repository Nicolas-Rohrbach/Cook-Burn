<?php

session_start();

include_once 'CONTROLLER/InterfaceController.php';
include_once 'VIEW/HtmlPage.php';

// /Admin/index/tot/1

$url = filter_input(INPUT_GET, 'url');
if (empty($url)) {
    $url = 'Accueil';
}
$urlExpl = explode('/', $url);
// $urlExpl[0] => nom du controller
// $urlExpl[1] => nom de l'action du controller

$controllerfile = 'CONTROLLER/' . $urlExpl[0] . '.php';
if (file_exists($controllerfile)) {
    include_once $controllerfile;
    if (class_exists($urlExpl[0])) {
        $ctrl = new $urlExpl[0]();
        if ($ctrl instanceof InterfaceController) {
            $action = 'display';
            if (isset($urlExpl[1])) {
                $action = $urlExpl[1];
            }
            if (method_exists($ctrl, $action)) {
                $ctrl->$action(array_slice($urlExpl, 2));
                exit;
            }
        }
    }
}





