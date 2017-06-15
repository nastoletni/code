const NewFormButton = {
  BUTTON_QUERY: '#new-file',
  LAST_FORM_QUERY: '.code-form--file:last-of-type',

  init() {
    this.index = 0;
    const button = document.querySelector(this.BUTTON_QUERY);
    button.addEventListener('click', () => this.onClick());
  },

  onClick() {
    this.index += 1;
    const lastForm = document.querySelector(this.LAST_FORM_QUERY);
    const newForm = this.getNewForm();
    const formsWrapper = lastForm.parentNode;

    formsWrapper.insertBefore(newForm, lastForm.nextSibling);
  },

  getNewForm() {
    const newForm = document.createElement('fieldset');
    newForm.setAttribute('class', 'code-form--file');
    newForm.setAttribute('data-index', this.index);

    newForm.innerHTML =
      `<label class="code-form--label" for="name[${this.index}]">Nazwa pliku (opcjonalna)</label>
       <input type="text" id="name[${this.index}]" name="name[${this.index}]" class="code-form--control">
       <label for="content[${this.index}]" class="code-form--label">Treść pliku</label>
       <textarea name="content[${this.index}]" id="content[${this.index}]" rows="10" class="code-form--control code-form--control__textarea"></textarea>`;

    return newForm;
  },
};

NewFormButton.init();
