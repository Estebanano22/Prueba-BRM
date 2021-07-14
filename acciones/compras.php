<?php

    require_once('conexion.php');

    $total = $_POST['total'];
    $cantidadComprar = $_POST['cantidadComprar'];
    $idProducto = $_POST['idProducto'];

    $UUID = uniqid();

    $stmt = $conexion->query("SELECT * FROM productos WHERE idProducto = '$idProducto'");
    $producto = $stmt->fetch();

    $cambioCantidad = $producto['cantidad'] - $cantidadComprar;

    if($producto['cantidad'] < $cantidadComprar) {

        $respuesta = array('titulo' => '¡Lo Sentimos!', 'resp' => 'error', 'descripcion' => 'No puede comprar más unidades que las disponibles.');

    } else {

        // Consultas DB
        $stmt = $conexion->prepare( "INSERT INTO compras (idCompra, idProducto, cantidad, total) VALUES (?,?,?,?)");
        $stmt->execute([$UUID, $idProducto, $cantidadComprar, $total]);

        $sql = "UPDATE productos SET cantidad=? WHERE idProducto=?";
        $stmt= $conexion->prepare($sql);
        $stmt->execute([$cambioCantidad, $idProducto]);
        
        $respuesta = array('titulo' => '¡Que bien!', 'resp' => 'success', 'descripcion' => 'Compra realizada con éxito.');

    }

    echo json_encode($respuesta, JSON_PRETTY_PRINT);

?>