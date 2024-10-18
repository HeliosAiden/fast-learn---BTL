<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import TableMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/table.js' ?>";
    import FormMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/form.js' ?>";
    import SnackBarMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/snackbar.js' ?>";
    const snackBar = new SnackBarMixin()

    let url = '/app/apis/user_info.php'
    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')
    let response = await httpMixin.getMixin(url)
    let data = response.data

    function openEditModal(user_info) {
        document.getElementById('edit-form-id').value = user_info.id
        document.getElementById('name').value = user_info.name;
        document.getElementById('description').value = user_info.description;
        document.getElementById('fee').value = user_info.fee;

        // Disable the "edit" button initially
        const editButton = document.getElementById('edit_user_info_btn')
        editButton.disabled = true;

        const initialData = {
            name: user_info.name,
            description: user_info.description,
            fee: user_info.fee
        };

        // edit event listeners to track changes
        document.getElementById('name').addEventListener('change', () => {
            // Compare current form data with initial data
            const dataChanged = document.getElementById('name').value !== initialData.name;

            // Enable the "Save Changes" button if data has changed
            editButton.disabled = !dataChanged;
        });

        document.getElementById('description').addEventListener('change', () => {
            // Compare current form data with initial data
            const dataChanged = document.getElementById('description').value !== initialData.description;

            // Enable the "Save Changes" button if data has changed
            editButton.disabled = !dataChanged;
        });

        document.getElementById('fee').addEventListener('change', () => {
            // Compare current form data with initial data
            const dataChanged = document.getElementById('fee').value !== initialData.fee;

            // Enable the "Save Changes" button if data has changed
            editButton.disabled = !dataChanged;
        });

        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    function openDeleteModal(user_info) {
        document.getElementById('delete-id').value = user_info.id

        const text = document.createElement('p')
        text.innerHTML = `<b>user_info name</b>: ${user_info.name}<br/>`
        if (user_info.description) {
            text.innerHTML += `<b>Description</b>: ${user_info.description}<br/>`
        }
        if (user_info.fee) {
            text.innerHTML += `<b>Fee</b>: ${user_info.fee}<br/>`
        }
        const modalBody = document.querySelector('#deleteModal .modal-body')
        modalBody.appendChild(text)

        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    const actions = [{
            label: 'Edit',
            className: 'btn-warning',
            handler: (rowData) => {
                openEditModal(rowData)
            }
        },
        {
            label: 'Delete',
            className: 'btn-danger',
            handler: (rowData) => {
                openDeleteModal(rowData)
            }
        }
    ];

    const tableMixin = new TableMixin(data, 5, ['id', 'Họ', 'Tên', 'Giới tính', 'Số điện thoại', 'ngày tháng năm sinh'], actions);
    tableMixin.render(document.getElementById('table-container'));
</script>