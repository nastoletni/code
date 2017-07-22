const Fieldset = {
  LAST_FORM_QUERY: '.code-form--file:last-of-type',

  addNew() {
    const lastForm = document.querySelector(this.LAST_FORM_QUERY);
    const newForm = this.getElement();
    const formsWrapper = lastForm.parentNode;

    formsWrapper.insertBefore(newForm, lastForm.nextSibling);
  },

  getElement() {
    const index = this.getNextIndex();
    const fieldset = document.createElement('fieldset');
    fieldset.setAttribute('class', 'code-form--file');
    fieldset.setAttribute('data-index', index);

    fieldset.innerHTML =
      `<label class="code-form--label" for="name[${index}]">Nazwa pliku (opcjonalna)</label>
       <input type="text" id="name[${index}]" name="name[${index}]" class="code-form--control">
       <label for="content[${index}]" class="code-form--label">Treść pliku</label>
       <textarea name="content[${index}]" id="content[${index}]" rows="10" class="code-form--control code-form--control__textarea" required></textarea>`;

    return fieldset;
  },

  getNextIndex() {
    const currentIndex = parseInt(document.querySelector(this.LAST_FORM_QUERY).getAttribute('data-index'), 10);

    return currentIndex + 1;
  },
};

const NewFormButton = {
  BUTTON_QUERY: '#new-file',

  init() {
    const button = document.querySelector(this.BUTTON_QUERY);
    button.addEventListener('click', () => this.onClick());
  },

  onClick() {
    Fieldset.addNew();
  },
};

const DragAndDrop = {
  FILE_FORM_QUERY: '.code-form--file',
  OVERLAY_WRAPPER_QUERY: 'body',

  init() {
    this.lastTarget = null;

    this.appendOverlay();
    this.handleDragEnter();
    this.handleDragLeave();
    this.handleDragOver();
    this.handleDrop();
  },

  handleDragEnter() {
    window.addEventListener('dragenter', (event) => {
      if (this.isFile(event)) {
        this.lastTarget = event.target;
        this.showOverlay();
      }
    });
  },

  handleDragLeave() {
    window.addEventListener('dragleave', (event) => {
      event.preventDefault();

      if (event.target === this.lastTarget) {
        this.hideOverlay();
      }
    });
  },

  handleDragOver() {
    window.addEventListener('dragover', (event) => {
      event.preventDefault();
    });
  },

  handleDrop() {
    window.addEventListener('drop', (event) => {
      event.preventDefault();
      this.hideOverlay();

      const files = [...event.dataTransfer.files]
          .filter(file => this.isReadable(file));

      if (files.length === 0) {
        return;
      }

      const fieldsetsToCreateNumber = files.length - this.getEmptyFieldsets().length;
      this.createNewFieldsets(fieldsetsToCreateNumber);

      const emptyFieldsets = this.getEmptyFieldsets();
      emptyFieldsets.forEach((fieldset, index) => this.fillFieldset(fieldset, files[index]))
    });
  },

  createNewFieldsets(number) {
    for(let i = 0; i < number; i++) {
      Fieldset.addNew();
    }
  },

  fillFieldset(fieldset, file) {
    const input = fieldset.querySelector('input');
    const textarea = fieldset.querySelector('textarea');

    input.value = this.getFileName(file);

    this.getFileContent(file).then(content => {
      textarea.value = content;
    });
  },

  getEmptyFieldsets() {
    const fieldsets = [...document.querySelectorAll(this.FILE_FORM_QUERY)];

    return fieldsets.filter(fieldset => this.isFieldsetEmpty(fieldset));
  },

  isFieldsetEmpty(fieldset) {
    const inputValue = fieldset.querySelector('input').value;
    const textareaValue = fieldset.querySelector('textarea').value;

    return inputValue + textareaValue === '';
  },

  isFile(event) {
    return event.dataTransfer.types.some(type => type === 'Files');
  },

  isReadable(file) {
    // Is it empty string, application/* or text/*?
    return /(^$|application\/.+|text\/.+)/.exec(file.type);
  },

  getFileName(file) {
    return file.name;
  },

  getFileContent(file) {
    return new Promise(resolve => {
      const fileReader = new FileReader();

      fileReader.readAsText(file);
      fileReader.onload = (event) => {
        resolve(event.target.result);
      };
    });
  },

  getOverlayElement() {
    const overlay =  document.createElement('div');
    overlay.classList.add('drop-overlay');
    overlay.innerHTML = `<p class="drop-overlay--text">Upuść pliki tutaj</p>`;

    return overlay;
  },

  appendOverlay() {
    const overlayWrapper = document.querySelector(this.OVERLAY_WRAPPER_QUERY);
    this.overlay = this.getOverlayElement();

    overlayWrapper.appendChild(this.overlay);
  },

  showOverlay() {
    this.overlay.classList.add('drop-overlay__active');
  },

  hideOverlay() {
    this.overlay.classList.remove('drop-overlay__active');
  },
};

DragAndDrop.init();
NewFormButton.init();
