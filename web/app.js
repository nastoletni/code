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

NewFormButton.init();
