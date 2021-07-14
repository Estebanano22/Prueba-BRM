<?php

    require_once('conexion.php');

    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $lote = $_POST['lote'];
    $fecha = $_POST['fecha'];
    $precio = $_POST['precio'];

    $UUID = 'BRM'.uniqid();
    
    // Consultas DB
    $stmt = $conexion->prepare( "INSERT INTO productos (idProducto, producto, cantidad, lote, fechaVencimiento, precio) VALUES (?,?,?,?,?,?)");
	$stmt->execute([$UUID, $producto, $cantidad, $lote, $fecha, $precio]);
    
    if($producto === '' || $cantidad === '' || $lote === '' || $fecha === '' || $precio === '') {
        $respuesta = array('titulo' => '¡Lo Sentimos!', 'resp' => 'error', 'descripcion' => 'Debes llenar todos los campos.');
    } else {
        $respuesta = array('titulo' => '¡Que bien!', 'resp' => 'success', 'descripcion' => 'producto subido con éxito.');
    }

    echo json_encode($respuesta, JSON_PRETTY_PRINT);

?>