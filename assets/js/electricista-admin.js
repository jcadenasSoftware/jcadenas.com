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

  const workForm = document.querySelector('form.electricista-admin-form-grid');
  if (workForm) {
    const coverInput = workForm.querySelector('#cover_image');
    const galleryInput = workForm.querySelector('#gallery_images');
    const csrfInput = workForm.querySelector('input[name="csrf_token"]');
    const submitButton = workForm.querySelector('button[type="submit"]');
    const uploadUrl = workForm.getAttribute('data-upload-url');
    const progress = workForm.querySelector('[data-upload-progress]');
    const progressBar = progress ? progress.querySelector('[data-upload-bar]') : null;
    const progressLabel = progress ? progress.querySelector('[data-upload-label]') : null;
    const progressPercent = progress ? progress.querySelector('[data-upload-percent]') : null;
    let uploading = false;

    const setProgress = (fraction, label) => {
      const pct = Math.max(0, Math.min(100, Math.round(fraction * 100)));
      if (progress) progress.hidden = false;
      if (progressBar) progressBar.style.width = pct + '%';
      if (progressPercent) progressPercent.textContent = pct + '%';
      if (progressLabel && label) progressLabel.textContent = label;
    };

    const showErrors = (messages, retryUrl) => {
      let alertBox = workForm.parentNode.querySelector('.electricista-ajax-errors');
      if (!alertBox) {
        alertBox = document.createElement('div');
        alertBox.className = 'alert alert-danger electricista-admin-alert electricista-ajax-errors';
        alertBox.setAttribute('role', 'alert');
        workForm.parentNode.insertBefore(alertBox, workForm);
      }
      const items = messages.map((m) => {
        const li = document.createElement('li');
        li.textContent = m;
        return li.outerHTML;
      }).join('');
      alertBox.innerHTML = '<ul class="mb-0">' + items + '</ul>' +
        (retryUrl ? '<a class="btn btn-sm btn-outline-light mt-2" href="' + retryUrl + '">Abrir el trabajo guardado</a>' : '');
      alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    };

    const postForm = (url, formData, onProgress) => new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.open('POST', url);
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      xhr.upload.addEventListener('progress', (e) => {
        if (e.lengthComputable && onProgress) onProgress(e.loaded / e.total);
      });
      xhr.addEventListener('load', () => {
        try {
          resolve({ status: xhr.status, body: JSON.parse(xhr.responseText) });
        } catch (e) {
          reject(new Error('La sesión pudo haber expirado o el servidor respondió de forma inesperada.'));
        }
      });
      xhr.addEventListener('error', () => reject(new Error('La conexión se interrumpió durante la subida. Intenta nuevamente.')));
      xhr.addEventListener('abort', () => reject(new Error('La subida fue cancelada.')));
      xhr.send(formData);
    });

    const resetUploadState = () => {
      uploading = false;
      if (submitButton) submitButton.disabled = false;
    };

    workForm.addEventListener('submit', (event) => {
      if (uploading) {
        event.preventDefault();
        return;
      }
      const galleryFiles = galleryInput ? Array.from(galleryInput.files || []) : [];
      const hasCover = !!(coverInput && coverInput.files && coverInput.files.length);
      const totalFiles = galleryFiles.length + (hasCover ? 1 : 0);
      if (totalFiles === 0 || !uploadUrl || !csrfInput) {
        return;
      }

      event.preventDefault();
      uploading = true;
      if (submitButton) submitButton.disabled = true;

      (async () => {
        try {
          const baseData = new FormData(workForm);
          baseData.delete('gallery_images[]');
          baseData.set('ajax', '1');

          setProgress(0, hasCover ? `Subiendo imagen 1 de ${totalFiles}…` : 'Guardando datos del trabajo…');
          const first = await postForm(workForm.getAttribute('action') || window.location.href, baseData, (f) => {
            if (hasCover) setProgress(f / totalFiles, `Subiendo imagen 1 de ${totalFiles}…`);
          });

          if (!first.body || first.body.ok !== true) {
            showErrors((first.body && first.body.errors) || ['No fue posible guardar el trabajo.']);
            resetUploadState();
            return;
          }

          const workId = first.body.work_id;
          const failures = [];
          const doneUnits = hasCover ? 1 : 0;

          for (let i = 0; i < galleryFiles.length; i++) {
            const unitIndex = doneUnits + i;
            const label = `Subiendo imagen ${unitIndex + 1} de ${totalFiles}…`;
            setProgress(unitIndex / totalFiles, label);

            const imageData = new FormData();
            imageData.set('csrf_token', csrfInput.value);
            imageData.set('work_id', String(workId));
            imageData.set('type', 'gallery');
            imageData.set('image', galleryFiles[i], galleryFiles[i].name);

            try {
              const res = await postForm(uploadUrl, imageData, (f) => {
                setProgress((unitIndex + f) / totalFiles, label);
              });
              if (!res.body || res.body.ok !== true) {
                failures.push(`${galleryFiles[i].name}: ${(res.body && res.body.error) || 'error desconocido'}`);
              }
            } catch (err) {
              failures.push(`${galleryFiles[i].name}: ${err.message}`);
            }
          }

          if (failures.length > 0) {
            failures.push('El trabajo se guardó de forma parcial. Abre el trabajo para revisar qué imágenes faltan y reintentarlas.');
            showErrors(failures, first.body.redirect);
            setProgress(1, 'Subida finalizada con errores');
            resetUploadState();
            return;
          }

          setProgress(1, 'Subida completa. Redirigiendo…');
          window.location.href = first.body.redirect;
        } catch (err) {
          showErrors([err.message]);
          resetUploadState();
        }
      })();
    });
  }
});
