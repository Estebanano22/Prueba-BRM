<?php 

    $_host = "localhost";
    $_usuario= "e_baq_full";
    $_contraseña = "cl";

    try {
        $conexion = new PDO("mysql:host=$_host;dbname=prueba_brm", $_usuario, $_contraseña);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->exec("set names utf8");
        return$conexion;
    }
    catch(PDOException $error) {
        echo "No se pudo conectar a la BD: " . $error->getMessage();
    }

 ?>