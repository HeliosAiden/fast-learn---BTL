<h2 class="text-center mb-4">Danh sách các môn học</h2>
<div class="text-end mb-3">
    <button id='add_subjects' class='btn btn-primary'>Add subject</button>
</div>
<div class="container mt-5">
    <div id="table-container"></div>
</div>

<!-- Add Subject Modal -->
<div class="modal" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Subject</h5>
                <button type="button" class="btn-close close-add-modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="add-name" class="form-label">Name<noscript></noscript></label>
                    <input type="text" class="form-control" id="add-name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-add-modal">Close</button>
                <button type="button" id="add-subject-btn" class="btn btn-success" disabled>Create subject</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Subject Modal -->
<div class="modal" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subject name</h5>
                <button type="button" class="btn-close close-edit-modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-form-id">
                <div class="mb-3">
                    <label for="edit-name" class="form-label">Name<noscript></noscript></label>
                    <input type="text" class="form-control" id="edit-name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-edit-modal">Close</button>
                <button type="button" id='edit-subject-btn' class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete subject</h5>
                <button type="button" class="btn-close close-delete-modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this subject ?</p>
                <input type="hidden" id="delete-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-delete-modal">Cancel</button>
                <button type="button" id="delete-subject-btn" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>


<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import TableMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/table.js' ?>";
    import FormMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/form.js' ?>";
    import SnackBarMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/snackbar.js' ?>";
    const snackBar = new SnackBarMixin()

    let url = '/app/apis/subject.php'
    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')
    let response = await httpMixin.getMixin(url)
    let data = response.data

    const createSubjectFormConfig = {
        id: 'create_subject_form',
        fields: [{
            type: "text",
            name: "create_name",
            placeholder: "Enter subject name"
        }]
    }

    const editSubjectFormConfig = {
        id: 'edit_subject_form',
        fields: [{
            type: "text",
            name: "edit_name",
            placeholder: "Enter subject name"
        }]
    }

    // ** Add Modal Form ** //
    const nameCreateInputId = 'add-name'

    function checkAddForm() {
        const name = document.getElementById(nameCreateInputId).value.trim();
        document.getElementById('add-subject-btn').disabled = !name;
    }

    function openAddModal() {
        document.getElementById(nameCreateInputId).value = '';

        // Disable the "Add Student" button initially
        document.getElementById('add-subject-btn').disabled = true;

        // Add event listeners to track changes
        document.getElementById(nameCreateInputId).addEventListener('input', checkAddForm);

        var addModal = new bootstrap.Modal(document.getElementById('addModal'));
        addModal.show();
    }

    function closeAddModal() {
        var addModal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
        addModal.hide();
    }

    const submitCreateSubject = async () => {
        let subjectName = document.getElementById(nameCreateInputId).value;

        var data = {
            name: subjectName,
        };

        let endpoint = 'app/apis/subject.php'
        response = await httpMixin.postMixin(endpoint, data)
        if (response.status == 'success') {
            snackBar.showMessage('Thêm môn học thành công')
        } else {
            snackBar.showMessage(response.message ?? 'Thêm môn học thất bại', 'danger')
        }
    }

    document.getElementById('add_subjects').addEventListener('click', openAddModal)
    document.querySelectorAll('.close-add-modal').forEach(btn => {
        btn.addEventListener('click', closeAddModal)
    })
    document.getElementById('add-subject-btn').addEventListener('click', () => {
        closeAddModal()
        submitCreateSubject()
        window.location.reload();
    })


    // ** Edit Modal Form ** //

    const nameEditInputId = 'edit-name'

    function openEditModal(subject) {
        document.getElementById(nameEditInputId).value = subject.name;
        document.getElementById('edit-form-id').value = subject.id

        // Disable the "edit Student" button initially
        document.getElementById('edit-subject-btn').disabled = true;

        const initialData = {
            name: subject.name
        };

        // edit event listeners to track changes
        document.getElementById(nameEditInputId).addEventListener('change', () => {

            const currentData = {
                name: document.getElementById(nameEditInputId).value
            };

            // Compare current form data with initial data
            const dataChanged = JSON.stringify(currentData) !== JSON.stringify(initialData);

            // Enable the "Save Changes" button if data has changed
            document.getElementById('edit-subject-btn').disabled = !dataChanged;
        });

        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    function closeEditModal() {
        var editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
        editModal.hide();
    }

    const submitEditSubject = async () => {
        let id = document.getElementById('edit-form-id').value;
        let subjectName = document.getElementById(nameEditInputId).value;

        var data = {
            id: id,
            name: subjectName,
        };

        let endpoint = 'app/apis/subject.php'
        response = await httpMixin.putMixin(endpoint, data)
        if (response.status == 'success') {
            snackBar.showMessage('Lưu môn học thành công', response.status)
        } else {
            snackBar.showMessage(response.message ?? 'Lưu môn học thất bại', 'danger')
        }
    }

    document.querySelectorAll('.close-edit-modal').forEach(btn => {
        btn.addEventListener('click', closeEditModal)
    })
    document.getElementById('edit-subject-btn').addEventListener('click', () => {
        closeEditModal()
        submitEditSubject()
        window.location.reload();
    })

    // ** Delete Modal Form ** //

    function openDeleteModal(subject) {
        document.getElementById('delete-id').value = subject.id

        const text = document.createElement('p')
        text.innerHTML = `<b>Subject name</b>: ${subject.name}`
        const modalBody = document.querySelector('#deleteModal .modal-body')
        modalBody.appendChild(text)

        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    function closeDeleteModal() {
        var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
        const modalBody = document.querySelector('#deleteModal .modal-body')
        modalBody.removeChild(modalBody.lastChild)
        deleteModal.hide();
    }

    const submitDeleteSubject = async () => {
        const id = document.getElementById('delete-id').value
        let endpoint = `app/apis/subject.php`
        response = await httpMixin.deleteMixin(endpoint, id)
        if (response.status == 'success') {
            snackBar.showMessage('Xóa môn học thành công', response.status)
        } else {
            snackBar.showMessage(response.message ?? 'Thêm môn học thất bại', 'danger')
        }
    }

    document.querySelectorAll('.close-delete-modal').forEach(btn => {
        btn.addEventListener('click', closeDeleteModal)
    })
    document.getElementById('delete-subject-btn').addEventListener('click', () => {
        closeDeleteModal()
        submitDeleteSubject()
        window.location.reload();
    })

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

    const tableMixin = new TableMixin(data, 5, ['id', 'name'], actions);
    tableMixin.render(document.getElementById('table-container'));
</script>