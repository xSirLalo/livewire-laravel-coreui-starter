/* global coreui */

/**
 * --------------------------------------------------------------------------
 * CoreUI Boostrap Admin Template tooltips.js
 * Licensed under MIT (https://github.com/coreui/coreui-free-bootstrap-admin-template/blob/main/LICENSE)
 * --------------------------------------------------------------------------
 */

for (const element of document.querySelectorAll('[data-coreui-toggle="tooltip"]')) {
  // eslint-disable-next-line no-new
  new coreui.Tooltip(element)

  Livewire.hook('morph.updated', () => {
    document.querySelectorAll('[data-coreui-toggle="tooltip"]').forEach(el => {
      // If the element is currently hovered, skip it
      if (el.matches(':hover')) {
        return;
      }
      const existingTooltip = coreui.Tooltip.getInstance(el);
      if (existingTooltip) {
        // Hide and dispose of the existing tooltip instance
        existingTooltip.hide();
        existingTooltip.dispose();
      }
      // Initialize a new tooltip for the element
      new coreui.Tooltip(el);
    });
  });
}
