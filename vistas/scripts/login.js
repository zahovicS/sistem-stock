const formulario = document.querySelector('#frmAcceso')
formulario.addEventListener('submit', function (e) {
  e.preventDefault()
  let formData = new FormData()
  formData.append('logina', document.querySelector('#logina').value)
  formData.append('clavea', document.querySelector('#clavea').value)
  fetch('../ajax/usuario.php?op=verificar', {
    method: 'POST',
    body: formData,
  })
    .then((response) => {
      return response.json()
    })
    .then((data) => {
      if (data != null) {
        location.href = 'escritorio.php'
      } else {
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Error de ingreso',
          //   subtitle: 'Subtitle',
          body: 'Los datos proporcionados son incorrectos.',
        })
      }
    })
})
