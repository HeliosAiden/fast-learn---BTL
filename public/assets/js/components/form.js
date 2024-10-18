class FormMixin {
    constructor(formConfig) {
        this.formConfig = formConfig;
    }

    // Method to create a form dynamically
    createForm() {
        const form = document.createElement('div');
        if (this.formConfig.class) {
            form.setAttribute('class', this.formConfig.class)
        }
        if (this.formConfig.id) {
            form.setAttribute('id', this.formConfig.id)
        }

        // Add title if provided
        if (this.formConfig.title) {
            const titleConfig = this.formConfig.title
            let title
            if (titleConfig.tag) {
                title = document.createElement(titleConfig.tag);
            } else {
                title = document.createElement('h2');
            }
            if (titleConfig.class) {
                title.setAttribute('class', titleConfig.class)
            }
            if (titleConfig.label) {
                title.innerText = titleConfig.label;
            }
            form.appendChild(title);
        }

        if (this.targetId) {
            const inputTarget = this.createInputTarget()
            form.appendChild(inputTarget)
        }

        // Create form fields
        this.formConfig.fields.forEach(field => {
            const formGroup = document.createElement('div');
            formGroup.classList.add('form-group', 'mb-3'); // Bootstrap styling

            // Create label if field label is provided
            if (field.label) {
                const label = document.createElement('label');
                label.setAttribute('for', field.name);
                label.innerText = field.label;
                formGroup.appendChild(label);
            }

            // Create input field based on its type
            let inputElement;
            switch (field.type) {
                case 'text':
                case 'password':
                case 'email':
                case 'number':
                case 'date':
                    inputElement = this.createInputField(field);
                    break;
                case 'select':
                    inputElement = this.createSelectField(field);
                    break;
                case 'checkbox':
                    inputElement = this.createCheckboxField(field);
                    break;
                case 'radio':
                    inputElement = this.createRadioButtonField(field);
                    break;
                case 'textarea':
                    inputElement = this.createTextareaField(field);
                    break;
                default:
                    console.error(`Unsupported field type: ${field.type}`);
            }

            if (inputElement) {
                formGroup.appendChild(inputElement);
                form.appendChild(formGroup);
            }
        });

        if (this.formConfig.buttonArea) {
            const buttonArea = this.createButtonArea(this.formConfig.buttonArea)
            form.appendChild(buttonArea)
        }

        return form;
    }

    appendIcon(element, iconClass) {
        const icon = document.createElement('i')
        icon.setAttribute('class', iconClass)
        element.appendChild(icon)
    }

    // Method to create a basic input field (text, password, email, etc.)
    createInputField(field) {
        const input = document.createElement('input');
        input.setAttribute('type', field.type);
        input.setAttribute('name', field.name);
        input.setAttribute('id', field.name);
        input.setAttribute('placeholder', field.placeholder || '');
        input.classList.add('form-control'); // Bootstrap styling
        return input;
    }

    // Method to create a select box
    createSelectField(field) {
        const select = document.createElement('select');
        select.setAttribute('name', field.name);
        select.setAttribute('id', field.name);
        select.classList.add('form-control'); // Bootstrap styling

        field.options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.value;
            opt.text = option.label;
            select.appendChild(opt);
        });

        return select;
    }

    // Method to create a checkbox
    createCheckboxField(field) {
        const div = document.createElement('div');
        div.classList.add('form-check');

        const input = document.createElement('input');
        input.setAttribute('type', 'checkbox');
        input.setAttribute('name', field.name);
        input.setAttribute('id', field.name);
        input.classList.add('form-check-input');

        const label = document.createElement('label');
        label.setAttribute('for', field.name);
        label.classList.add('form-check-label');
        label.innerText = field.label;

        div.appendChild(input);
        div.appendChild(label);
        return div;
    }

    // Method to create radio buttons
    createRadioButtonField(field) {
        const div = document.createElement('div');

        field.options.forEach(option => {
            const radioDiv = document.createElement('div');
            radioDiv.classList.add('form-check');

            const input = document.createElement('input');
            input.setAttribute('type', 'radio');
            input.setAttribute('name', field.name);
            input.setAttribute('value', option.value);
            input.setAttribute('id', `${field.name}-${option.value}`);
            input.classList.add('form-check-input');

            const label = document.createElement('label');
            label.setAttribute('for', `${field.name}-${option.value}`);
            label.classList.add('form-check-label');
            label.innerText = option.label;

            radioDiv.appendChild(input);
            radioDiv.appendChild(label);
            div.appendChild(radioDiv);
        });

        return div;
    }

    // Method to create a textarea
    createTextareaField(field) {
        const textarea = document.createElement('textarea');
        textarea.setAttribute('name', field.name);
        textarea.setAttribute('id', field.name);
        textarea.setAttribute('placeholder', field.placeholder || '');
        textarea.classList.add('form-control');
        return textarea;
    }

    createButtonArea(buttons) {
        const buttonArea = document.createElement('div')
        buttonArea.setAttribute('class', 'd-flex justify-content-center mt-4')
        buttons.forEach(button => {
            let newButton
            if (button.tag) {
                newButton = document.createElement(button.tag);
            } else {
                newButton = document.createElement('button');
            }
            if (button.type) {
                newButton.setAttribute('type', button.type)
            }
            if (button.href) {
                newButton.setAttribute('href', button.href)
            }
            if (button.target) {
                newButton.setAttribute('target', button.target)
            }
            if (button.class) {
                newButton.setAttribute('class', button.class)
            } else {
                newButton.classList.add('btn', 'btn-primary'); // Bootstrap styling
            }
            if (button.id) {
                newButton.setAttribute('id', button.id);
            }
            const iconConfig = button.icon
            if (iconConfig?.class && iconConfig?.position == 'start') {
                this.appendIcon(newButton, iconConfig.class)
            }
            if (button.label) {
                newButton.innerText = button.label;
            } else {
                newButton.innerText = "Submit";
            }
            if (iconConfig?.class && iconConfig?.position == 'end') {
                this.appendIcon(newButton, iconConfig.class)
            }
            buttonArea.appendChild(newButton);
        });
        return buttonArea
    }

    createInputTarget() {
        const inputTarget = document.createElement('input')
        inputTarget.setAttribute('type', 'hidden')
        inputTarget.setAttribute('id', 'input_target_id')
        inputTarget.setAttribute('value', this.targetId)
        return inputTarget
    }

    setInputTarget(id) {
        this.targetId = id
    }

    // Method to render the form into a DOM element
    render(selector) {
        const targetElement = document.querySelector(selector);
        if (targetElement) {
            const existingForm = targetElement.querySelector(`#${this.formConfig.id}` ?? `.${this.formConfig.class}`);
            if (!existingForm) {
                const formElement = this.createForm();
                targetElement.appendChild(formElement);
            }
        } else {
            console.error(`Element with selector ${selector} not found`);
        }
    }
}

export default FormMixin;
