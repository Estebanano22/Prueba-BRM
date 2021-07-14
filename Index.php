<?php
    require_once('acciones/conexion.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario Simple || Prueba BRM</title>
    <link rel="icon" type="image/png" href="img/favicon.png">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!-- sweet alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- data tables -->
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>
<body>

    <section>
        <div class="row justify-content-center">
            <div class="col-md-3 p-0 seccion-menu" id="menu">
                <div class="tipo-formulario seccion1 cursor-pointer tipo-formulario-active" onclick="stepProveedor();">
                    <h3 class="text-white">Formulario Proveedor</h3>
                </div>
                <div class="tipo-formulario seccion2 cursor-pointer" onclick="stepCompra();">
                    <h3 class="text-white">Formulario Compra</h3>
                </div>
                <div class="tipo-formulario seccion3 cursor-pointer" onclick="stepVisualizacion();">
                    <h3 class="text-white">Formulario Visualización</h3>
                </div>
            </div>
            <div class="col-md-9 seccion-form">
                <div id="formProveedor" class="div-form pb-5">
                
                    <div class="table-responsive card-white">
                        
                        <h3 class="mb-4 mt-2" style="float: left;">Inventario</h3>

                        <button type="button" class="btn btn-primary mb-4 mt-2" data-bs-toggle="modal" data-bs-target="#subirProducto" style="float: right;">
                        Subir Producto
                        </button>
                        
                        <table class="table table-bordered" id="tablaInventario">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Lote</th>
                                    <th>Precio</th>
                                    <th>Fecha Vencimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $stmt = $conexion->query("SELECT * FROM productos");
                                while ($row = $stmt->fetch()) {
                            ?>

                            <tr>
                                <td class="casillas"><?php echo $row['idProducto']; ?></td>
                                <td class="casillas"><?php echo $row['producto']; ?></td>
                                <td class="casillas"><?php echo $row['cantidad']; ?></td>
                                <td class="casillas"><?php echo $row['lote']; ?></td>
                                <td class="casillas"><?php echo $row['precio']; ?></td>
                                <td class="casillas"><?php echo $row['fechaVencimiento']; ?></td>
                            </tr>

                            <?php        
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div id="formCompra" class="div-form pb-5 card-white display-none m-4">

                    <h3 class="mb-4 mt-2">Productos</h3>
                    
                    <div class="row justify-content-center">

                    <?php 
                        $stmt = $conexion->query("SELECT * FROM productos");
                        while ($row = $stmt->fetch()) {
                    ?>

                    <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <img src="img/default.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['producto']; ?></h5>
                                <p class="card-text">
                                    <strong>Lote:</strong> <?php echo $row['lote']; ?><br>
                                    <strong>Cantidad Disponible:</strong> <?php echo $row['cantidad']; ?><br>
                                    <strong>Precio Unidad:</strong> <?php echo $row['precio']; ?><br>
                                    <strong>Fecha de Vencimiento:</strong> <?php echo $row['fechaVencimiento']; ?>
                                </p>
                                <?php 
                                    if($row['cantidad'] != 0) {
                                ?>
                                    <button data-bs-toggle="modal" data-bs-target="#comprarProducto" class="btn btn-primary" onclick="modalComprar(event, '<?php echo $row['idProducto']; ?>', '<?php echo $row['producto']; ?>', '<?php echo $row['precio']; ?>', '<?php echo $row['cantidad']; ?>')">Comprar</button>
                                <?php
                                    } else {
                                ?>
                                    <button class="btn btn-secondary">Comprar</button>
                                <?php 
                                    }
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php        
                        }
                    ?>

                    </div>

                </div>

                <div id="formVisualizacion" class="div-form pb-5 display-none">

                <div class="table-responsive card-white">
                        
                        <h3 class="mb-4 mt-2">Compras</h3>
                        
                        <table class="table table-bordered" id="tablaCompras">
                            <thead>
                                <tr>
                                    <th>ID Compra</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Total Pagado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $stmt = $conexion->query("SELECT * FROM compras");
                                while ($row = $stmt->fetch()) {

                                $idProducto = $row['idProducto'];

                                $stmt2 = $conexion->query("SELECT * FROM productos WHERE idProducto = '$idProducto'");
                                $producto = $stmt2->fetch();
                            ?>

                            <tr>
                                <td class="casillas"><?php echo $row['idCompra']; ?></td>
                                <td class="casillas"><?php echo $producto['producto']; ?></td>
                                <td class="casillas"><?php echo $row['cantidad']; ?></td>
                                <td class="casillas">$ <?php echo $row['total']; ?></td>
                                <td class="text-capitalize">
                                    <div class="btn btn-list">
                                        <a class="btn ripple btn-warning modal-effect" title="Factura" data-bs-toggle="modal" data-bs-target="#modalFactura" onclick="factura(event, '<?php echo $row['idCompra'] ?>')"><i class="bi bi-printer"></i></a>
                                        <a class="btn ripple btn-danger modal-effect" title="Eliminar" onclick="eliminarCompra(event, '<?php echo $row['idCompra'] ?>')"><i class="bi bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>

                            <?php        
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </section>

<!-- Modal -->
<div class="modal fade" id="subirProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Entrega de productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                    
        <label for="seleccionarProductoProveedor" class="pb-2"> Seleccionar Producto</label>
        <select class="form-select" aria-label="Default select example" id="seleccionarProductoProveedor">
            <option value="" selected>Seleccione un producto</option>
            <option value="Lata Salchichas Zenu x 12">Lata Salchichas Zenu x 12</option>
            <option value="Jamon Enlatado 125gr">Jamon Enlatado 125gr</option>
            <option value="Maiz Tierno en lata 210gr">Maiz Tierno en lata 210gr</option>
            <option value="Salchichas Mini x 12">Salchichas Mini x 12</option>
            <option value="Arbeja en lata x 120gr">Arbeja en lata x 120gr</option>
            <option value="Ensalada Light lata x 200gr">Ensalada Light lata x 200gr</option>
            <option value="Frijoles x 180gr">Frijoles x 180gr</option>
            <option value="Mermemlada de fresa x 170gr">Mermemlada de fresa x 170gr</option>
        </select>

        <div class="mb-3 mt-3">
            <label for="cantidadProductoProveedor" class="form-label">Ingrese la cantidad</label>
            <input type="number" class="form-control" id="cantidadProductoProveedor" placeholder="0">
        </div>

        <div class="mb-3">
            <label for="loteProductoProveedor" class="form-label">Ingrese el número de lote</label>
            <input type="text" class="form-control" id="loteProductoProveedor" placeholder="EJ0000">
        </div>

        <div class="mb-3 mt-3">
            <label for="fechaProductoProveedor" class="form-label">Ingrese la fecha de vencimiento</label>
            <input type="date" class="form-control" id="fechaProductoProveedor" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>" placeholder="0">
        </div>

        <div class="mb-3 mt-3">
            <label for="precioProductoProveedor" class="form-label">Ingrese el precio</label>
            <input type="number" class="form-control" id="precioProductoProveedor" placeholder="0">
        </div>

        <div class="alert alert-danger display-none" role="alert" id="alerta">hola</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" onclick="ingresarProducto(event)">Ingresar Producto</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="comprarProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Comprar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <h3 id="produtoCompra"></h3>
            <p class="mb-0">Canditad disponible: <span id="cantidadDisponible"></span></p>
            <p class="mb-0">Precio Unidad: <span id="precioUnidad"></span></p>
            <input type="hidden" name="" id="idProducto" value="">
            <label for="" class="mt-3">Cantidad a comprar: </label>
            <input type="number" name="cantidadComprar" id="cantidadComprar" max="" min="0" onkeyup="calcular();">

            <h4>Total: $ <span id="total">0</span></h4>

            <div class="alert alert-danger display-none" role="alert" id="alerta2">hola</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" onclick="comprarProducto(event)">Comprar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalFactura" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Factura</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       
        <h5 id="productoFactura"></h5>

        <div class="row">
            <div class="col-6">
                <p class="mb-0">Cantidad</p>
                <p class="mb-0">Valor Unidad</p>
                <p class="mb-0">Total</p>
            </div>
            <div class="col-6 text-right">
                <p style="text-align: right;" class="mb-0"><span id="cantidadFactura"></span> Unid.</p>
                <p style="text-align: right;" class="mb-0">$ <span id="unidadFactura"></span></p>
                <p style="text-align: right;" class="mb-0">$ <span id="totalFactura"></span></p>
            </div>
        </div>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> 
      </div>
    </div>
  </div>
</div>

<script src="js/main.js"></script>

</body>
</html>