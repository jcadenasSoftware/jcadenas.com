document.addEventListener('DOMContentLoaded', () => {
  const titleInput = document.querySelector('[data-slug-source]');
  const slugInput = document.querySelector('[data-slug-target]');

  const slugify = (value) => value
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '');

  if (titleInput && slugInput) {
    let slugManuallyEdited = slugInput.value.trim() !== '';

    slugInput.addEventListener('input', () => {
      slugManuallyEdited = slugInput.value.trim() !== '';
    });

    titleInput.addEventListener('input', () => {
      if (slugManuallyEdited) {
        return;
      }
      slugInput.value = slugify(titleInput.value);
    });
  }

  document.querySelectorAll('[data-confirm]').forEach((element) => {
    element.addEventListener('click', (event) => {
      const message = element.getAttribute('data-confirm') || '¿Deseas continuar?';
      if (!window.confirm(message)) {
        event.preventDefault();
      }
    });
  });

  document.querySelectorAll('.electricista-admin-file-input').forEach((input) => {
    const field = input.closest('.electricista-admin-file-field');
    const status = field?.querySelector('.electricista-admin-file-status');
    if (!status) {
      return;
    }

    const defaultText = status.getAttribute('data-default') || 'Sin archivo seleccionado';
    const isMultiple = input.hasAttribute('multiple') || status.getAttribute('data-multiple') === 'true';

    const updateStatus = () => {
      if (!input.files || input.files.length === 0) {
        status.textContent = defaultText;
        return;
      }

      if (isMultiple) {
        const count = input.files.length;
        status.textContent = `${count} ${count === 1 ? 'imagen seleccionada' : 'imágenes seleccionadas'}`;
      } else {
        status.textContent = input.files[0].name;
      }
    };

    input.addEventListener('change', updateStatus);
    updateStatus();
  });
});
