<h2 class="text-center mb-4">Danh sách các khóa học</h2>
<div class="text-end mb-3">
    <button id='open_add_modal' class='btn btn-primary'>Thêm khóa học</button>
</div>
<div class="container mt-5">
    <div id="table-container"></div>
</div>

<?php require_once __DIR__ . '/modals/add_modal.php' ?>
<?php require_once __DIR__ . '/modals/edit_modal.php' ?>
<?php require_once __DIR__ . '/modals/delete_modal.php' ?>



<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import TableMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/table.js' ?>";
    import FormMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/form.js' ?>";
    import SnackBarMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/snackbar.js' ?>";
    const snackBar = new SnackBarMixin()

    let url = '/app/apis/course.php'
    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')
    let response = await httpMixin.getMixin(url)
    let data = response.data

    function openEditModal(course) {
        document.getElementById('edit-form-id').value = course.id
        document.getElementById('name').value = course.name;
        document.getElementById('description').value = course.description;
        document.getElementById('fee').value = course.fee;

        // Disable the "edit" button initially
        const editButton = document.getElementById('edit_course_btn')
        editButton.disabled = true;

        const initialData = {
            name: course.name,
            description: course.description,
            fee: course.fee
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

    function openDeleteModal(course) {
        document.getElementById('delete-id').value = course.id

        const text = document.createElement('p')
        text.innerHTML = `<b>Course name</b>: ${course.name}<br/>`
        if (course.description) {
            text.innerHTML += `<b>Description</b>: ${course.description}<br/>`
        }
        if (course.fee) {
            text.innerHTML += `<b>Fee</b>: ${course.fee}<br/>`
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

    const tableMixin = new TableMixin(data, 5, ['id', 'tên khóa học', 'mô tả, học phí', 'id khóa học', 'id giáo viên', 'ngày bắt đầu', 'ngày kết thúc'], actions);
    tableMixin.render(document.getElementById('table-container'));
</script>