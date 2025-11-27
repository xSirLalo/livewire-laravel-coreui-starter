/*!
* Color mode toggler for CoreUI's docs (https://coreui.io/)
* Copyright (c) 2025 creativeLabs Łukasz Holeczek
* Licensed under the Creative Commons Attribution 3.0 Unported License.
*/

(() => {
  const THEME = 'coreui-free-bootstrap-admin-template-theme'

  const getStoredTheme = () => localStorage.getItem(THEME)
  const setStoredTheme = theme => localStorage.setItem(THEME, theme)

  const getPreferredTheme = () => {
    const storedTheme = getStoredTheme()

    if (storedTheme) {
      return storedTheme
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
  }

  const setTheme = theme => {
    if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      document.documentElement.setAttribute('data-coreui-theme', 'dark')
    } else {
      document.documentElement.setAttribute('data-coreui-theme', theme)
    }

    const event = new Event('ColorSchemeChange')
    document.documentElement.dispatchEvent(event)
  }

  setTheme(getPreferredTheme())

  const showActiveTheme = theme => {
    const activeThemeIcon = document.querySelector('.theme-icon-active')
    const btnToActive = document.querySelector(`[data-coreui-theme-value="${theme}"]`)

    if (!activeThemeIcon || !btnToActive) return

    const iconOfActiveBtn = btnToActive.querySelector('i')

    for (const element of document.querySelectorAll('[data-coreui-theme-value]')) {
      element.classList.remove('active')
    }

    btnToActive.classList.add('active')

    // Cambiar el icono del botón principal según el tema
    if (iconOfActiveBtn) {
      // Extraer solo la clase del icono (ej: cil-sun, cil-moon, cil-contrast)
      const iconClass = Array.from(iconOfActiveBtn.classList).find(cls => cls.startsWith('cil-'))
      if (iconClass) {
        // Limpiar las clases anteriores del icono y aplicar las nuevas
        activeThemeIcon.className = `${iconClass} icon icon-lg theme-icon-active`
      }
    }
  }

  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    const storedTheme = getStoredTheme()
    if (storedTheme !== 'light' || storedTheme !== 'dark') {
      setTheme(getPreferredTheme())
    }
  })

  window.addEventListener('DOMContentLoaded', () => {
    const preferredTheme = getPreferredTheme()
    showActiveTheme(preferredTheme)

    for (const toggle of document.querySelectorAll('[data-coreui-theme-value]')) {
      toggle.addEventListener('click', (e) => {
        e.preventDefault()
        const theme = toggle.getAttribute('data-coreui-theme-value')
        setStoredTheme(theme)
        setTheme(theme)
        showActiveTheme(theme)
      })
    }
  })

  // También ejecutar cuando el tema cambie por el sistema
  window.addEventListener('load', () => {
    showActiveTheme(getPreferredTheme())
  })
})()
