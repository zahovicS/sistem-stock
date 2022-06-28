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
  inputCodigo.value = ''
  inputNombre.value = ''
  inputDescripcion.value = ''
  inputStock.value = ''
  imagenmuestra.attributes.src = ''
  inputImagenactual.value = ''
  inputCodigoArticulo.value = ''
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
//listar productos
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
const guardaryeditar = (e) => {
  e.preventDefault() //no se activara la accion predeterminada
  btnGuardar.disabled = true
  const formData = new FormData(formulario)
  fetch('../ajax/articulo.php?op=guardaryeditar', {
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
      tablaArticulo.forceRender()
    })
  limpiar()
}
//mostrar producto
const mostrar = (idarticulo) => {
  let formData = new FormData()
  formData.append('idarticulo', idarticulo)
  fetch('../ajax/articulo.php?op=mostrar', {
    method: 'POST',
    body: formData,
  })
    .then((response) => {
      return response.json()
    })
    .then((data) => {
      mostrarform(true)
      selectCategoria.value = data.idcategoria
      inputCodigo.value = data.codigo
      inputNombre.value = data.nombre
      inputDescripcion.value = data.descripcion
      inputStock.value = data.stock
      imagenmuestra.attributes.src = '../files/articulos/' + data.imagen
      inputImagenactual.value = data.imagen
      inputCodigoArticulo.value = data.idarticulo
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
      let formData = new FormData()
      formData.append('idarticulo', idarticulo)
      fetch('../ajax/articulo.php?op=desactivar', {
        method: 'POST',
        body: formData,
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
    confirmButtonText: 'Activar',
    cancelButtonText: 'Cancelar',
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      let formData = new FormData()
      formData.append('idarticulo', idarticulo)
      fetch('../ajax/articulo.php?op=activar', {
        method: 'POST',
        body: formData,
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

const generarbarcode = (_) => {
  const codigo = Math.floor(Math.random() * 9999999999 + 1)
  inputCodigo.value = codigo
}

init()
