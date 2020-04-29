<?php
require_once 'config/global.php';

if(isset($_GET["controller"])){
        $controllerObj=cargarControlador($_GET["controller"]);
        lanzarAccion($controllerObj);
}else{
        $controllerObj=cargarControlador(CONTROLADOR_DEFECTO);
        lanzarAccion($controllerObj);
}

function cargarControlador($controller){
        $controlador=ucwords($controller).'Controller';
        $strFileController='controller/'.$controlador.'.php';
        if(!is_file($strFileController)) {
        $strFileController='controller/'.ucwords(CONTROLADOR_DEFECTO).'Controller.php';   
    }
        require_once $strFileController;
        $controllerObj=new $controlador();
    return $controllerObj;
}

function lanzarAccion($controllerObj) {
    if(isset($_GET["action"])){
        $controllerObj->run($_GET["action"]);
    }else{
        $controllerObj->run(ACCION_DEFECTO);
    }
}



?>