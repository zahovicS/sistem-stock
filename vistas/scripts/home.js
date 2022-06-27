const navs = document.querySelectorAll('.nav .nav-item .nav-link')
navs.forEach((nav) => {
  const flag = nav.pathname === window.location.pathname
  if (flag) {
    if (nav.parentElement.parentElement.classList.contains('nav-treeview')) {
      nav.parentElement.parentElement.style.display = 'block'
      nav.parentElement.parentElement.parentElement.classList.add(
        'menu-is-opening',
        'menu-open'
      )
      nav.parentElement.parentElement.parentElement.children[0].classList.add(
        'active'
      )
    }
    nav.classList.add('active')
  } else {
    nav.classList.remove('active')
  }
})
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  },
})

/// Native fadeOut
const fadeOut = (el, ms, remove = false) => {
  if (ms) {
    el.style.transition = `opacity ${ms}ms`
    el.addEventListener(
      'transitionend',
      function (event) {
        el.style.display = 'none'
      },
      false
    )
  }
  el.style.opacity = '0'
}
// Native fadeIn
const fadeIn = (elem, ms) => {
  elem.style.opacity = 0

  if (ms) {
    let opacity = 0
    const timer = setInterval(function () {
      opacity += 50 / ms
      if (opacity >= 1) {
        clearInterval(timer)
        opacity = 1
      }
      elem.style.opacity = opacity
    }, 50)
  } else {
    elem.style.opacity = 1
  }
}
const hide = (e) => {
  e.style.display = 'none'
}
const show = (e, custom = null) => {
  if (custom) {
    e.style.display = custom
    return
  }
  e.style.display = 'block'
}
