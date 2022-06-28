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
  inputSerie = document.querySelector('#serie_comprobante'),
  inputNumeroC = document.querySelector('#num_comprobante'),
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
  inputClient.selectedIndex = 0
  inputSerie.value = ''
  inputNumeroC.value = ''
  marcarImpuesto()
  inputTotalVenta.value = ''
  remove(filasTablaVenta)
  totalText.innerHTML = 0
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
    show(btnCancelar)
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
  //   if (tablaVenta) {
  //     tableVentasHTML.innerHTML = ''
  //   }
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
      'Número',
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
  }).render(tableVentasHTML)
}

const listarArticulos = () => {
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
      inputSerie.value = data.serie_comprobante
      inputNumeroC.value = data.num_comprobante
      inputFecha.value = data.fecha
      inputImpuesto.value = data.impuesto
      idventa.value = data.idventa
      //ocultar y mostrar los botones
      hide(btnGuardar)
      show(btnCancelar)
      hide(btnAgregarArt)
    })
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
    $('#impuesto').val(impuesto)
  } else {
    $('#impuesto').val('0')
  }
}
hide(btnGuardar)
inputTipoComprobante.addEventListener('change', marcarImpuesto)
function agregarDetalle(idarticulo, articulo, precio_venta) {
  var cantidad = 1
  var descuento = 0

  if (idarticulo != '') {
    var subtotal = cantidad * precio_venta
    var fila =
      '<tr class="filas" id="fila' +
      cont +
      '">' +
      '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' +
      cont +
      ')">X</button></td>' +
      '<td><input type="hidden" name="idarticulo[]" value="' +
      idarticulo +
      '">' +
      articulo +
      '</td>' +
      '<td><input type="number" name="cantidad[]" id="cantidad[]" value="' +
      cantidad +
      '"></td>' +
      '<td><input type="number" name="precio_venta[]" id="precio_venta[]" value="' +
      precio_venta +
      '"></td>' +
      '<td><input type="number" name="descuento[]" value="' +
      descuento +
      '"></td>' +
      '<td><span id="subtotal' +
      cont +
      '" name="subtotal">' +
      subtotal +
      '</span></td>' +
      '<td><button type="button" onclick="modificarSubtotales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>' +
      '</tr>'
    cont++
    detalles++
    $('#detalles').append(fila)
    modificarSubtotales()
  } else {
    alert('error al ingresar el detalle, revisar las datos del articulo ')
  }
}

function modificarSubtotales() {
  var cant = document.getElementsByName('cantidad[]')
  var prev = document.getElementsByName('precio_venta[]')
  var desc = document.getElementsByName('descuento[]')
  var sub = document.getElementsByName('subtotal')

  for (var i = 0; i < cant.length; i++) {
    var inpV = cant[i]
    var inpP = prev[i]
    var inpS = sub[i]
    var des = desc[i]

    inpS.value = inpV.value * inpP.value - des.value
    document.getElementsByName('subtotal')[i].innerHTML = inpS.value
  }
  calcularTotales()
}

function calcularTotales() {
  var sub = document.getElementsByName('subtotal')
  var total = 0.0

  for (var i = 0; i < sub.length; i++) {
    total += document.getElementsByName('subtotal')[i].value
  }
  $('#total').html('S/.' + total)
  $('#total_venta').val(total)
  evaluar()
}

function evaluar() {
  if (detalles > 0) {
    $('#btnGuardar').show()
  } else {
    $('#btnGuardar').hide()
    cont = 0
  }
}

function eliminarDetalle(indice) {
  $('#fila' + indice).remove()
  calcularTotales()
  detalles = detalles - 1
}

init()
