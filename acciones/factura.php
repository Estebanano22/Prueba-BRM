<?php

    require_once('conexion.php');

    $idCompra = $_POST['id'];

    $stmt = $conexion->query("SELECT * FROM compras WHERE idCompra = '$idCompra'");
    $compra = $stmt->fetch();

    $idProducto = $compra['idProducto'];
    $cantidad = $compra['cantidad'];
    $total = $compra['total'];

    $stmt = $conexion->query("SELECT * FROM productos WHERE idProducto = '$idProducto'");
    $producto = $stmt->fetch();

    $producto1 = $producto['producto'];
    $unidad = $producto['precio'];

    $respuesta = array('titulo' => '¡Que bien!', 'resp' => 'success', 'producto' => $producto1, 'cantidad' => $cantidad, 'unidad' => $unidad, 'total' => $total);

    echo json_encode($respuesta, JSON_PRETTY_PRINT);

?>