/*!
* Sidebar state controller for CoreUI Admin Template
* Manages sidebar visibility and narrow states with localStorage persistence
*/

(() => {
  const SIDEBAR_STATE = 'coreui-sidebar-state'

  const getStoredSidebarState = () => localStorage.getItem(SIDEBAR_STATE)
  const setStoredSidebarState = state => localStorage.setItem(SIDEBAR_STATE, state)

  const getDefaultSidebarState = () => {
    const storedState = getStoredSidebarState()
    if (storedState) {
      return storedState
    }
    // Estado por defecto basado en el tamaño de pantalla
    return window.innerWidth >= 992 ? 'show' : 'hide'
  }

  const setSidebarState = state => {
    const sidebar = document.querySelector('#sidebar')
    if (!sidebar) return

    // Limpiar todas las clases de estado previas
    sidebar.classList.remove('hide', 'sidebar-narrow-unfoldable')

    switch (state) {
      case 'hide':
        sidebar.classList.add('hide')
        break
      case 'narrow':
        sidebar.classList.add('sidebar-narrow-unfoldable')
        break
      case 'show':
        // Estado normal, sin clases adicionales
        break
      default:
        // Fallback al estado normal
        break
    }

    // Disparar evento personalizado para notificar el cambio
    const event = new CustomEvent('SidebarStateChange', {
      detail: { state: state }
    })
    document.dispatchEvent(event)
  }

  // Inicializar el sidebar con el estado guardado
  const initializeSidebar = () => {
    const state = getDefaultSidebarState()
    setSidebarState(state)
  }

  // Manejar el botón hamburguesa (toggle show/hide)
  const handleHamburgerToggle = () => {
    const currentState = getStoredSidebarState() || 'show'
    const newState = currentState === 'hide' ? 'show' : 'hide'

    setStoredSidebarState(newState)
    setSidebarState(newState)
  }

  // Manejar el botón unfoldable (toggle narrow/show)
  const handleUnfoldableToggle = () => {
    const currentState = getStoredSidebarState() || 'show'
    const newState = currentState === 'narrow' ? 'show' : 'narrow'

    setStoredSidebarState(newState)
    setSidebarState(newState)
  }

  // Manejar cambios de tamaño de ventana
  const handleWindowResize = () => {
    const currentState = getStoredSidebarState()

    // En pantallas pequeñas, forzar hide si no hay estado guardado
    if (window.innerWidth < 992 && !currentState) {
      setStoredSidebarState('hide')
      setSidebarState('hide')
    }
  }

  // Inicializar cuando el DOM esté listo
  window.addEventListener('DOMContentLoaded', () => {
    initializeSidebar()

    // Event listener para el botón hamburguesa
    const hamburgerBtn = document.querySelector('.header-toggler')
    if (hamburgerBtn) {
      hamburgerBtn.addEventListener('click', (e) => {
        e.preventDefault()
        handleHamburgerToggle()
      })
    }

    // Event listener para el botón unfoldable
    const unfoldableBtn = document.querySelector('.sidebar-toggler')
    if (unfoldableBtn) {
      unfoldableBtn.addEventListener('click', (e) => {
        e.preventDefault()
        handleUnfoldableToggle()
      })
    }

    // Event listener para el botón de cerrar (móvil)
    const closeBtn = document.querySelector('.sidebar-close-btn')
    if (closeBtn) {
      closeBtn.addEventListener('click', (e) => {
        e.preventDefault()
        setStoredSidebarState('hide')
        setSidebarState('hide')
      })
    }

    // Event listener para cambios de tamaño de ventana
    window.addEventListener('resize', handleWindowResize)
  })

  // También inicializar en load para mayor seguridad
  window.addEventListener('load', () => {
    initializeSidebar()
  })

  // Exponer funciones globalmente si es necesario
  window.SidebarController = {
    setState: (state) => {
      setStoredSidebarState(state)
      setSidebarState(state)
    },
    getState: () => getStoredSidebarState(),
    toggle: () => handleHamburgerToggle(),
    toggleNarrow: () => handleUnfoldableToggle()
  }
})()
