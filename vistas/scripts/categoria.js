let tablaCategoria
const inputNombre = document.querySelector('#nombre'),
  inputDescripcion = document.querySelector('#descripcion'),
  formulario = document.querySelector('#formulario'),
  tableCategoriaHTML = document.querySelector('#tbllistado'),
  listadoregistros = document.querySelector('#listadoregistros'),
  formularioregistros = document.querySelector('#formularioregistros'),
  btnGuardar = document.querySelector('#btnGuardar'),
  btnagregar = document.querySelector('#btnagregar'),
  inputCodigoCategoria = document.querySelector('#idcategoria')

//funcion que se ejecuta al inicio
const init = () => {
  mostrarform(false)
  listar()

  formulario.addEventListener('submit', (e) => {
    guardaryeditar(e)
  })
}

//funcion limpiar
const limpiar = () => {
  inputCodigoCategoria.value = ''
  inputNombre.value = ''
  inputDescripcion.value = ''
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
const cancelarform = () => {
  limpiar()
  mostrarform(false)
}

//funcion listar
const listar = () => {
  tablaCategoria = new gridjs.Grid({
    columns: [
      {
        name: 'Opciones',
        formatter: (cell) => gridjs.html(cell),
      },
      'Nombre',
      'Descripcion',
      {
        name: 'Estado',
        formatter: (cell) => gridjs.html(cell),
      },
    ],
    server: {
      url: '../ajax/categoria.php?op=listar',
      then: (data) =>
        data.aaData.map((card) => [card.op, card.name, card.desc, card.est]),
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
  }).render(tableCategoriaHTML)
}
//funcion para guardaryeditar
const guardaryeditar = (e) => {
  e.preventDefault() //no se activara la accion predeterminada
  btnGuardar.disabled = true
  const formData = new FormData(formulario)
  fetch('../ajax/categoria.php?op=guardaryeditar', {
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
      tablaCategoria.forceRender()
    })
  limpiar()
}

const mostrar = (idcategoria) => {
  let formData = new FormData()
  formData.append('idcategoria', idcategoria)
  fetch('../ajax/categoria.php?op=mostrar', {
    method: 'POST',
    body: formData,
  })
    .then((response) => {
      return response.json()
    })
    .then((data) => {
      mostrarform(true)
      inputNombre.value = data.nombre
      inputDescripcion.value = data.descripcion
      inputCodigoCategoria.value = data.idcategoria
    })
}

//funcion para desactivar
const desactivar = (idcategoria) => {
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
      formData.append('idcategoria', idcategoria)
      fetch('../ajax/categoria.php?op=desactivar', {
        method: 'POST',
        body: formData,
      })
        .then((response) => {
          return response.text()
        })
        .then((data) => {
          tablaCategoria.forceRender()
          Toast.fire({
            icon: 'success',
            title: data,
          })
        })
    }
  })
}

const activar = (idcategoria) => {
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
      formData.append('idcategoria', idcategoria)
      fetch('../ajax/categoria.php?op=activar', {
        method: 'POST',
        body: formData,
      })
        .then((response) => {
          return response.text()
        })
        .then((data) => {
          tablaCategoria.forceRender()
          Toast.fire({
            icon: 'success',
            title: data,
          })
        })
    }
  })
}

init()
