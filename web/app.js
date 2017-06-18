const NewFormButton = {
  BUTTON_QUERY: '#new-file',
  LAST_FORM_QUERY: '.code-form--file:last-of-type',

  init() {
    const button = document.querySelector(this.BUTTON_QUERY);
    button.addEventListener('click', () => this.onClick());
  },

  onClick() {
    const lastForm = document.querySelector(this.LAST_FORM_QUERY);
    const newForm = this.getNewForm();
    const formsWrapper = lastForm.parentNode;

    formsWrapper.insertBefore(newForm, lastForm.nextSibling);
  },

  getNewForm() {
    const index = this.getNextIndex();
    const newForm = document.createElement('fieldset');
    newForm.setAttribute('class', 'code-form--file');
    newForm.setAttribute('data-index', index);

    newForm.innerHTML =
      `<label class="code-form--label" for="name[${index}]">Nazwa pliku (opcjonalna)</label>
       <input type="text" id="name[${index}]" name="name[${index}]" class="code-form--control">
       <label for="content[${index}]" class="code-form--label">Treść pliku</label>
       <textarea name="content[${index}]" id="content[${index}]" rows="10" class="code-form--control code-form--control__textarea"></textarea>`;

    return newForm;
  },

  getNextIndex() {
    const currentIndex = parseInt(document.querySelector(this.LAST_FORM_QUERY).getAttribute('data-index'), 10);

    return currentIndex + 1;
  },
};

const DragAndDrop = {
  PLACEHOLDER_QUERY: '.drop--placeholder',
  FILE_FORM_QUERY: '.code-form--file',

  init() {
    this.lastTarget = null;
    this.placeholder = document.querySelector(this.PLACEHOLDER_QUERY);

    this.handleDragEnter();
    this.handleDragLeave();
    this.handleDragOver();
    this.handleDrop();
  },

  handleDragEnter() {
    window.addEventListener("dragenter", (event) => {
      if (this.isFile(event)) {
        this.lastTarget = event.target;
        this.showPlaceholder();
      }
    });
  },

  handleDragLeave() {
    window.addEventListener("dragleave", (event) => {
      event.preventDefault();

      if (event.target === this.lastTarget) {
        this.hidePlaceholder();
      }
    });
  },

  handleDragOver() {
    window.addEventListener("dragover", (event) => {
      event.preventDefault();
    });
  },

  handleDrop() {
    window.addEventListener("drop", (event) => {
      event.preventDefault();
      this.hidePlaceholder();

      const files = [...event.dataTransfer.files]
        .filter(file => this.isReadable(file));

      const fieldsetsToCreateNumber = files.length - this.getEmptyFieldsets().length;
      this.createNewFieldsets(fieldsetsToCreateNumber);

      const emptyFieldsets = this.getEmptyFieldsets();
      emptyFieldsets.forEach((fieldset, index) => this.fillFieldset(fieldset, files[index]))
    });
  },

  createNewFieldsets(number) {
    for(let i = 0; i < number; i++) {
      NewFormButton.onClick();
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
    return event.dataTransfer.types.some(type => type === "Files");
  },

  isReadable(file) {
    return file.type.indexOf("text") == 0;
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

  showPlaceholder() {
    this.placeholder.classList.add('drop--placeholder__active');
  },

  hidePlaceholder() {
    this.placeholder.classList.remove('drop--placeholder__active');
  },
};

DragAndDrop.init();
NewFormButton.init();
