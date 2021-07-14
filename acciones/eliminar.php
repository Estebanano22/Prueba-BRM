<?php

    require_once('conexion.php');

    $idCompra = $_POST['id'];

    $stmt = $conexion->query("SELECT * FROM compras WHERE idCompra = '$idCompra'");
    $compra = $stmt->fetch();

    $idProducto = $compra['idProducto'];

    $stmt = $conexion->query("SELECT * FROM productos WHERE idProducto = '$idProducto'");
    $producto = $stmt->fetch();

    $cambioCantidad = $compra['cantidad'] + $producto['cantidad'];

    $sql = "UPDATE productos SET cantidad=? WHERE idProducto=?";
    $stmt= $conexion->prepare($sql);
    $stmt->execute([$cambioCantidad, $idProducto]);

    // Consultas DB
    $stmt = $conexion->prepare( "DELETE FROM compras WHERE idCompra=?");
    $stmt->execute([$idCompra]);

    $respuesta = array('titulo' => '¡Que bien!', 'resp' => 'success', 'descripcion' => 'Compra eliminada con éxito.');

    echo json_encode($respuesta, JSON_PRETTY_PRINT);

?>