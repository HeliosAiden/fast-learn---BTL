class FormMixin {
    constructor(formConfig) {
        this.formConfig = formConfig;
    }

    // Method to create a form dynamically
    createForm() {
        const form = document.createElement('div');

        // Add title if provided
        if (this.formConfig.title) {
            const title = document.createElement('h2');
            title.innerText = this.formConfig.title;
            form.appendChild(title);
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

        // Create submit button
        const submitButton = document.createElement('button');
        submitButton.setAttribute('type', 'submit');
        submitButton.classList.add('btn', 'btn-primary'); // Bootstrap styling
        if (this.formConfig.submitButton.id) {
            submitButton.setAttribute('id', this.formConfig.submitButton.id);
        }
        if (this.formConfig.submitButton.label) {
            submitButton.innerText = this.formConfig.submitButton.label;
        } else {
            submitButton.innerText = "Submit";
        }
        form.appendChild(submitButton);

        return form;
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

    // Method to render the form into a DOM element
    render(selector) {
        const targetElement = document.querySelector(selector);
        if (targetElement) {
            const formElement = this.createForm();
            targetElement.appendChild(formElement);
        } else {
            console.error(`Element with selector ${selector} not found`);
        }
    }
}

export default FormMixin;
