stepProveedor = () => {

    const formProveedor = document.getElementById('formProveedor');
    const formCompra = document.getElementById('formCompra');
    const formVisualizacion = document.getElementById('formVisualizacion');

    formProveedor.classList.remove('display-none');
    formCompra.classList.add('display-none');
    formVisualizacion.classList.add('display-none');

}

stepCompra = () => {

    const formProveedor = document.getElementById('formProveedor');
    const formCompra = document.getElementById('formCompra');
    const formVisualizacion = document.getElementById('formVisualizacion');

    formCompra.classList.remove('display-none');
    formProveedor.classList.add('display-none');
    formVisualizacion.classList.add('display-none');

}

stepVisualizacion = () => {

    const formProveedor = document.getElementById('formProveedor');
    const formCompra = document.getElementById('formCompra');
    const formVisualizacion = document.getElementById('formVisualizacion');

    formVisualizacion.classList.remove('display-none');
    formProveedor.classList.add('display-none');
    formCompra.classList.add('display-none');

}

ingresarProducto = (e) => {

    const seleccionarProductoProveedor = document.getElementById('seleccionarProductoProveedor').value.trim();
    const cantidadProductoProveedor = document.getElementById('cantidadProductoProveedor').value.trim();
    const loteProductoProveedor = document.getElementById('loteProductoProveedor').value.trim();
    const fechaProductoProveedor = document.getElementById('fechaProductoProveedor').value.trim();
    const precioProductoProveedor = document.getElementById('precioProductoProveedor').value.trim();

    if(seleccionarProductoProveedor === '' || cantidadProductoProveedor === '' || loteProductoProveedor === '' || fechaProductoProveedor === '' || precioProductoProveedor === '') {

        if(seleccionarProductoProveedor === '') {
            var validacionError = 'Debe seleccionar un producto';
        } else if(cantidadProductoProveedor === '') {
            var validacionError = 'Debe ingresar un valor en cantidad de productos';
        } else if(loteProductoProveedor === '') {
            var validacionError = 'Debe ingresar una referencia ó número de lote';
        } else if(fechaProductoProveedor === '') {
            var validacionError = 'Debe ingresar una fecha de vencimiento dle producto';
        } else if(precioProductoProveedor === '') {
            var validacionError = 'Debe ingresar un valor en precio';
        }
        $('#alerta').fadeIn();
        const error = '<strong>Oh no!</strong> '+ validacionError +'.';
        $('#alerta').html(error);
        $('#alerta').delay(2000).fadeOut();

    } else {

        const data = new FormData();
            data.append('producto', seleccionarProductoProveedor);
            data.append('cantidad', cantidadProductoProveedor);
            data.append('lote', loteProductoProveedor);
            data.append('fecha', fechaProductoProveedor);
            data.append('precio', precioProductoProveedor);

        fetch('/acciones/proveedores.php', {
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(data => {
            const respuesta = JSON.parse(data);
            
            if(respuesta.resp === 'success'){

                Swal.fire({
                    title: 'Que bien!',
                    text: 'Se ha ingresado el producto con éxito.',
                    icon: 'success',
                    confirmButtonText: 'Cerrar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                })

            } else {

                $('#alerta').fadeIn();
                const error = '<strong>Oh no!</strong> '+ respuesta.descripcion +'.';
                $('#alerta').html(error);
                $('#alerta').delay(2000).fadeOut();
            }
        })
    }
}

const menu = document.getElementById("menu");

const btns = menu.getElementsByClassName("tipo-formulario");

for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var cambio = document.getElementsByClassName("tipo-formulario-active");
    cambio[0].className = cambio[0].className.replace(" tipo-formulario-active", "");
    this.className += " tipo-formulario-active";
  });
}

modalComprar = (e, id, producto, precio, cantidad) => {
    const produtoCompra = document.getElementById('produtoCompra');
    const cantidadDisponible = document.getElementById('cantidadDisponible');
    const precioUnidad = document.getElementById('precioUnidad');
    const cantidadComprar = document.getElementById('cantidadComprar');
    const idProducto = document.getElementById('idProducto');

    produtoCompra.innerHTML = producto;
    cantidadDisponible.innerHTML = cantidad;
    precioUnidad.innerHTML = precio;
    cantidadComprar.setAttribute("max",cantidad);
    idProducto.value = id;
}

calcular = (e) => {
    const cantidadComprar = document.getElementById('cantidadComprar').value;
    const cantidadDisponible = document.getElementById('cantidadDisponible').innerHTML;
    const precioUnidad = document.getElementById('precioUnidad').innerHTML;
    const total = document.getElementById('total');

    if(Number(cantidadComprar) > Number(cantidadDisponible)) {
        $('#alerta2').fadeIn();
        const error = '<strong>Oh no!</strong> No puede comprar más de '+cantidadDisponible+' unidades.';
        $('#alerta2').html(error);
        $('#alerta2').delay(2000).fadeOut();
    } else {
        const totalCompra = Number(cantidadComprar) * Number(precioUnidad);
        total.innerHTML = totalCompra;
    }
}

comprarProducto = () => {
    const total = document.getElementById('total').innerHTML;
    const cantidadComprar = document.getElementById('cantidadComprar').value;
    const idProducto = document.getElementById('idProducto').value;

    const data = new FormData();
        data.append('total', total);
        data.append('cantidadComprar', cantidadComprar);
        data.append('idProducto', idProducto);

    fetch('/acciones/compras.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {
        const respuesta = JSON.parse(data);
        
        if(respuesta.resp === 'success'){

            Swal.fire({
                title: 'Que bien!',
                text: 'Se ha realizado la compra con éxito, podra verificar el inventario actualizado.',
                icon: 'success',
                confirmButtonText: 'Cerrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            })

        } else {

            $('#alerta2').fadeIn();
            const error = '<strong>Oh no!</strong> '+ respuesta.descripcion +'.';
            $('#alerta2').html(error);
            $('#alerta2').delay(2000).fadeOut();
        }
    })
}

eliminarCompra = (e, id) => {
    const data = new FormData();
        data.append('id', id);

    fetch('/acciones/eliminar.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {
        const respuesta = JSON.parse(data);
        
        if(respuesta.resp === 'success'){

            Swal.fire({
                title: 'Que bien!',
                text: 'Se ha eliminado la compra cn éxito.',
                icon: 'success',
                confirmButtonText: 'Cerrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            })

        }
    })
}

factura = (e, id) => {

    const data = new FormData();
        data.append('id', id);

    fetch('/acciones/factura.php', {
        method: 'POST',
        body: data
    })
    .then(res => res.text())
    .then(data => {
        const respuesta = JSON.parse(data);
        
        if(respuesta.resp === 'success'){

            const productoFactura = document.getElementById('productoFactura');
            const cantidadFactura = document.getElementById('cantidadFactura');
            const unidadFactura = document.getElementById('unidadFactura');
            const totalFactura = document.getElementById('totalFactura');

            productoFactura.innerHTML = respuesta.producto;
            cantidadFactura.innerHTML = respuesta.cantidad;
            unidadFactura.innerHTML = respuesta.unidad;
            totalFactura.innerHTML = respuesta.total;

        }
    })

}

// Tablas

var table = $('#tablaInventario').DataTable( {
    responsive: true,
    language: {
          searchPlaceholder: 'Buscar...',
          sSearch: '',
          lengthMenu: '_MENU_ filas/pagina',
       buttons: {
          'copy': 'Copiar',
          'excel': 'Excel',
          'pdf': 'PDF',
          'colvis': 'Ocultar columnas'
       },
       paginate: {
          'first': 'Primero',
          'last': 'Último',
          'next': 'Siguiente',
          'previous': 'Anterior'
      },
      },
      lengthChange: false,
      buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
  } );

  var table2 = $('#tablaCompras').DataTable( {
    responsive: true,
    language: {
          searchPlaceholder: 'Buscar...',
          sSearch: '',
          lengthMenu: '_MENU_ filas/pagina',
       buttons: {
          'copy': 'Copiar',
          'excel': 'Excel',
          'pdf': 'PDF',
          'colvis': 'Ocultar columnas'
       },
       paginate: {
          'first': 'Primero',
          'last': 'Último',
          'next': 'Siguiente',
          'previous': 'Anterior'
      },
      },
      lengthChange: false,
      buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
  } );