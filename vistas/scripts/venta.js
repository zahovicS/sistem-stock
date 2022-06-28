const btnGuardar = document.querySelector('#btnGuardar'),
  btnCancelar = document.querySelector('#btnCancelar'),
  btnagregar = document.querySelector('#btnagregar'),
  btnAgregarArt = document.querySelector('#btnAgregarArt'),
  tableVentasHTML = document.querySelector('#tbllistado'),
  tableArticuloHTML = document.querySelector('#tblarticulos'),
  listadoregistros = document.querySelector('#listadoregistros'),
  formularioregistros = document.querySelector('#formularioregistros'),
  formulario = document.querySelector('#formulario'),
  inputClient = document.querySelector('#idcliente'),
  inputTipoComprobante = document.querySelector('#tipo_comprobante'),
  inputImpuesto = document.querySelector('#impuesto'),
  inputTotalVenta = document.querySelector('#total_venta'),
  filasTablaVenta = document.querySelectorAll('.filas'),
  totalText = document.querySelector('#total'),
  inputFecha = document.querySelector('#fecha_hora'),
  idventa = document.querySelector('#idventa'),
  tablaDetalle = document.querySelector('#detalles')

//declaramos variables necesarias para trabajar con las compras y sus detalles
let tablaVenta,
  tblarticulos,
  impuesto = 18,
  cont = 0,
  detalles = 0
//funcion que se ejecuta al inicio
const init = () => {
  mostrarform(false)
  listar()

  formulario.addEventListener('submit', (e) => {
    guardaryeditar(e)
  })

  fetch('../ajax/venta.php?op=selectCliente', {
    method: 'POST',
  })
    .then((response) => {
      return response.text()
    })
    .then((data) => {
      inputClient.innerHTML = data
      //   $('#idcliente').select2({
      //     theme: 'bootstrap4',
      //   })
    })
}

//funcion limpiar
const limpiar = () => {
  remove(document.querySelectorAll('.filas'))
  inputClient.selectedIndex = 0
  marcarImpuesto()
  inputTotalVenta.value = ''
  document.querySelector('#total').innerHTML = 'S/.0.00'
  inputTotalVenta.value = 0
  //obtenemos la fecha actual
  const now = new Date()
  const day = ('0' + now.getDate()).slice(-2)
  const month = ('0' + (now.getMonth() + 1)).slice(-2)
  const today = now.getFullYear() + '-' + month + '-' + day
  inputFecha.value = today
  //marcamos el primer tipo_documento
  inputTipoComprobante.selectedIndex = 2
}

//funcion mostrar formulario
const mostrarform = (flag) => {
  limpiar()
  if (flag) {
    hide(listadoregistros)
    show(formularioregistros)
    hide(btnagregar)
    listarArticulos()
    hide(btnGuardar)
    show(btnCancelar, 'inline-block')
    detalles = 0
    show(btnAgregarArt)
  } else {
    show(listadoregistros)
    hide(formularioregistros)
    show(btnagregar, 'inline-block')
  }
}

//cancelar form
const cancelarform = () => {
  limpiar()
  mostrarform(false)
}

//funcion listar
const listar = () => {
  tablaVenta = new gridjs.Grid({
    columns: [
      {
        name: 'Opciones',
        formatter: (cell) => gridjs.html(cell),
      },
      'Fecha',
      'Cliente',
      'Usuario',
      'Tipo',
      'Serie-numero',
      'Total',
      {
        name: 'Estado',
        formatter: (cell) => gridjs.html(cell),
      },
    ],
    server: {
      url: '../ajax/venta.php?op=listar',
      then: (data) =>
        data.aaData.map((card) => [
          card.op,
          card.fecha,
          card.clie,
          card.user,
          card.tipo,
          card.numero,
          card.total,
          card.est,
        ]),
    },
    search: true,
    pagination: true,
    sort: true,
    language: {
      search: {
        placeholder: '🔍 Buscar...',
      },
      pagination: {
        previous: 'Retroceder',
        next: 'Avanzar',
        showing: 'Mostrando',
        results: () => 'resultados',
        of: 'de',
        to: 'a',
      },
    },
    style: {
      table: {
        width: '100%',
      },
    },
  }).render(tableVentasHTML)
}

const listarArticulos = () => {
  tableArticuloHTML.innerHTML = ''
  tablaArticulo = new gridjs.Grid({
    columns: [
      {
        name: 'Opciones',
        formatter: (cell) => gridjs.html(cell),
      },
      'Nombre',
      'Categoría',
      'Código',
      'Stock',
      'Precio',
      {
        name: 'Imagen',
        formatter: (cell) => gridjs.html(cell),
      },
    ],
    server: {
      url: '../ajax/venta.php?op=listarArticulos',
      then: (data) =>
        data.aaData.map((card) => [
          card.op,
          card.name,
          card.cat,
          card.cod,
          card.stock,
          card.price,
          card.image,
        ]),
    },
    search: true,
    pagination: true,
    sort: true,
    language: {
      search: {
        placeholder: '🔍 Buscar...',
      },
      pagination: {
        previous: 'Retroceder',
        next: 'Avanzar',
        showing: 'Mostrando',
        results: () => 'resultados',
        of: 'de',
        to: 'a',
      },
    },
    style: {
      table: {
        width: '100%',
      },
    },
  }).render(tableArticuloHTML)
}
//funcion para guardaryeditar
const guardaryeditar = (e) => {
  e.preventDefault() //no se activara la accion predeterminada
  const formData = new FormData(formulario)
  fetch('../ajax/venta.php?op=guardaryeditar', {
    method: 'POST',
    body: formData,
  })
    .then((response) => {
      return response.text()
    })
    .then((data) => {
      Toast.fire({
        icon: 'success',
        title: data,
      })
      mostrarform(false)
      tablaVenta.forceRender()
    })
}

const mostrar = (idventa) => {
  let formData = new FormData()
  formData.append('idventa', idventa)
  fetch('../ajax/venta.php?op=mostrar', {
    method: 'POST',
    body: formData,
  })
    .then((response) => {
      return response.json()
    })
    .then((data) => {
      mostrarform(true)
      inputClient.value = data.idcliente
      inputTipoComprobante.value = data.tipo_comprobante
      inputFecha.value = data.fecha
      inputImpuesto.value = data.impuesto
      idventa.value = data.idventa
      //ocultar y mostrar los botones
      hide(btnGuardar)
      show(btnCancelar)
      hide(btnAgregarArt)
      fetch('../ajax/venta.php?op=listarDetalle&id=' + idventa, {
        method: 'POST',
        body: formData,
      })
        .then((response) => {
          return response.text()
        })
        .then((data) => {
          tablaDetalle.innerHTML = data
        })
    })
}

//funcion para desactivar
function anular(idventa) {
  Swal.fire({
    title: '¿Esta seguro de desactivar este dato?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Desactivar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      let formData = new FormData()
      formData.append('idventa', idventa)
      fetch('../ajax/venta.php?op=anular', {
        method: 'POST',
        body: formData,
      })
        .then((response) => {
          return response.text()
        })
        .then((data) => {
          tablaVenta.forceRender()
          Toast.fire({
            icon: 'success',
            title: data,
          })
        })
    }
  })
}
const marcarImpuesto = () => {
  const tipo_comprobante =
    inputTipoComprobante.options[inputTipoComprobante.selectedIndex].value
  if (tipo_comprobante == 'Factura' || tipo_comprobante == 'Boleta') {
    inputImpuesto.value = impuesto
  } else {
    inputImpuesto.value = 0
  }
}
hide(btnGuardar)
inputTipoComprobante.addEventListener('change', marcarImpuesto)
const agregarDetalle = (idarticulo, articulo, precio_venta) => {
  let cantidad = 1
  let descuento = 0

  if (idarticulo != '') {
    const subtotal = cantidad * precio_venta
    let fila =
      '<tr class="filas" id="fila' +
      cont +
      '">' +
      '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' +
      cont +
      ')"><i class="fas fa-trash-alt"></i></button></td>' +
      '<td><input type="hidden" name="idarticulo[]" class="form-control form-control-border border-width-2" value="' +
      idarticulo +
      '">' +
      articulo +
      '</td>' +
      '<td><input type="number" name="cantidad[]" oninput="modificarSubtotales()"  class="form-control form-control-border border-width-2" id="cantidad[]" value="' +
      cantidad +
      '"></td>' +
      '<td><input type="number" name="precio_venta[]" oninput="modificarSubtotales()" class="form-control form-control-border border-width-2" id="precio_venta[]" value="' +
      precio_venta +
      '"></td>' +
      '<td><input type="number" name="descuento[]" oninput="modificarSubtotales()" class="form-control form-control-border border-width-2" value="' +
      descuento +
      '"></td>' +
      '<td><span id="subtotal' +
      cont +
      '" name="subtotal">' +
      subtotal +
      '</span></td>' +
      '</tr>'
    cont++
    detalles++
    // tablaDetalle.append(fila)
    $('#detalles').append(fila)
    modificarSubtotales()
  } else {
    alert('error al ingresar el detalle, revisar las datos del articulo ')
  }
}

const modificarSubtotales = () => {
  let cant = document.getElementsByName('cantidad[]')
  let prev = document.getElementsByName('precio_venta[]')
  let desc = document.getElementsByName('descuento[]')
  let sub = document.getElementsByName('subtotal')

  for (let i = 0; i < cant.length; i++) {
    const inpV = cant[i]
    const inpP = prev[i]
    const inpS = sub[i]
    const des = desc[i]

    inpS.value = inpV.value * inpP.value - des.value
    document.getElementsByName('subtotal')[i].innerHTML = inpS.value
  }
  calcularTotales()
}

const calcularTotales = () => {
  const sub = document.getElementsByName('subtotal')
  let total = 0.0

  for (let i = 0; i < sub.length; i++) {
    total += document.getElementsByName('subtotal')[i].value
  }
  document.querySelector('#total').innerHTML = 'S/.' + total
  inputTotalVenta.value = total
  evaluar()
}

const evaluar = () => {
  if (detalles > 0) {
    show(btnGuardar, 'inline-block')
  } else {
    hide(btnGuardar)
    cont = 0
  }
}

const eliminarDetalle = (indice) => {
  document.querySelector('#fila' + indice).remove()
  calcularTotales()
  detalles = detalles - 1
}
// const verVenta = (tipo) => {
//   let formData = new FormData()
//   formData.append('tipo_comprobante', tipo)
//   fetch('../ajax/venta.php?op=contarVentas', {
//     method: 'POST',
//     body: formData,
//   })
//     .then((response) => {
//       return response.json()
//     })
//     .then((data) => {
//       console.log(data)
//     })
// }
init()
