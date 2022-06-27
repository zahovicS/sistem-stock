let tablaArticulo
const imagenmuestra = document.querySelector('#imagenmuestra'),
  selectCategoria = document.querySelector('#idcategoria'),
  formulario = document.querySelector('#formulario'),
  inputCodigo = document.querySelector('#codigo'),
  inputNombre = document.querySelector('#nombre'),
  inputDescripcion = document.querySelector('#descripcion'),
  inputStock = document.querySelector('#stock'),
  inputImagenactual = document.querySelector('#imagenactual'),
  inputCodigoArticulo = document.querySelector('#idarticulo'),
  listadoregistros = document.querySelector('#listadoregistros'),
  formularioregistros = document.querySelector('#formularioregistros'),
  btnGuardar = document.querySelector('#btnGuardar'),
  btnagregar = document.querySelector('#btnagregar'),
  tableArticuloHTML = document.querySelector('#tableArticulo')
//funcion que se ejecuta al inicio
const init = () => {
  mostrarform(false)
  listar()
  formulario.addEventListener('submit', (e) => {
    guardaryeditar(e)
  })
  //cargamos los items al celect categoria
  fetch('../ajax/articulo.php?op=selectCategoria', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json, text-plain, */*',
      'X-Requested-With': 'XMLHttpRequest',
    },
  })
    .then((response) => {
      return response.text()
    })
    .then((data) => {
      selectCategoria.innerHTML = data
    })
  hide(imagenmuestra)
}

//funcion limpiar
const limpiar = (_) => {
  inputCodigo.val = ''
  inputNombre.val = ''
  inputDescripcion.val = ''
  inputStock.val = ''
  imagenmuestra.attributes.src = ''
  inputImagenactual.val = ''
  inputCodigoArticulo.val = ''
  hide(imagenmuestra)
}

//funcion mostrar formulario
const mostrarform = (flag) => {
  limpiar()
  if (flag) {
    hide(listadoregistros)
    show(formularioregistros)
    btnGuardar.disabled = false
    hide(btnagregar)
  } else {
    show(listadoregistros)
    hide(formularioregistros)
    show(btnagregar, 'inline-block')
  }
}

//cancelar form
const cancelarform = (_) => {
  limpiar()
  mostrarform(false)
}
const listar = () => {
  tablaArticulo = new gridjs.Grid({
    columns: [
      {
        name: 'Opciones',
        formatter: (cell) => gridjs.html(cell),
      },
      'Nombre',
      'Categoria',
      'Codigo',
      'Stock',
      {
        name: 'Imagen',
        formatter: (cell) => gridjs.html(cell),
      },
      'Descripcion',
      {
        name: 'Estado',
        formatter: (cell) => gridjs.html(cell),
      },
    ],
    server: {
      url: '../ajax/articulo.php?op=listar',
      then: (data) =>
        //   console.log(data),
        data.aaData.map((card) => [
          card.op,
          card.name,
          card.cat,
          card.cod,
          card.stock,
          card.img,
          card.desc,
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
  }).render(tableArticuloHTML)
}
//funcion para guardaryeditar
function guardaryeditar(e) {
  e.preventDefault() //no se activara la accion predeterminada
  btnGuardar.disabled = true
  const formData = new FormData(formulario)
  fetch('../ajax/articulo.php?op=guardaryeditar', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json, text-plain, */*',
      'X-Requested-With': 'XMLHttpRequest',
    },
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
      // mostrarform(false)
      // tablaArticulo.forceRender()
    })
  // limpiar()
}
const mostrar = (idarticulo) => {
  fetch('../ajax/articulo.php?op=mostrar', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json, text-plain, */*',
      'X-Requested-With': 'XMLHttpRequest',
    },
    body: JSON.stringify({
      idarticulo: idarticulo,
    }),
  })
    .then((response) => {
      return response.json()
    })
    .then((data) => {
      mostrarform(true)
      $('#idcategoria').val(data.idcategoria)
      // $('#idcategoria').selectpicker('refresh')
      $('#codigo').val(data.codigo)
      $('#nombre').val(data.nombre)
      $('#stock').val(data.stock)
      $('#descripcion').val(data.descripcion)
      $('#imagenmuestra').show()
      $('#imagenmuestra').attr('src', '../files/articulos/' + data.imagen)
      $('#imagenactual').val(data.imagen)
      $('#idarticulo').val(data.idarticulo)
      // generarbarcode()
    })
}

//funcion para desactivar
const desactivar = (idarticulo) => {
  Swal.fire({
    title: '¿Esta seguro de desactivar este dato?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Desactivar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      fetch('../ajax/articulo.php?op=desactivar', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json, text-plain, */*',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
          idarticulo: idarticulo,
        }),
      })
        .then((response) => {
          return response.text()
        })
        .then((data) => {
          tablaArticulo.forceRender()
          Toast.fire({
            icon: 'success',
            title: data,
          })
        })
    }
  })
}

const activar = (idarticulo) => {
  Swal.fire({
    title: '¿Esta seguro de activar este dato?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Desactivar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      fetch('../ajax/articulo.php?op=activar', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json, text-plain, */*',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
          idarticulo: idarticulo,
        }),
      })
        .then((response) => {
          return response.text()
        })
        .then((data) => {
          tablaArticulo.forceRender()
          Toast.fire({
            icon: 'success',
            title: data,
          })
        })
    }
  })
}

function generarbarcode() {
  codigo = $('#codigo').val()
  JsBarcode('#barcode', codigo)
  $('#print').show()
}

function imprimir() {
  $('#print').printArea()
}

init()
