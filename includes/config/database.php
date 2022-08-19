<?php 

function conectarDB() : mysqli {
    $db = new mysqli('eu-cdbr-west-03.cleardb.net', 'b192b8b803baba', '165419b1', 'heroku_50e75c410e60130');  //'bienesraices_crud'

    //$db = new mysqli('localhost', 'root', 'root123', 'bienes_raices');  //'bienesraices_crud'

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    } 
    return $db;
    
}