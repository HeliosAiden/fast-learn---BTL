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
                    <label for="add-name"  class="form-label">Name<noscript></noscript></label>
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
                <input type="hidden" id="edit-id">
                <div class="mb-3">
                    <label for="edit-name" class="form-label">Name<noscript></noscript></label>
                    <input type="text" class="form-control" id="edit-name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-edit-modal">Close</button>
                <button type="button" id='submit-edit' class="btn btn-primary">Save changes</button>
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
    const nameInputId = 'add-name'

    function checkAddForm() {
        const name = document.getElementById(nameInputId).value.trim();
        document.getElementById('add-subject-btn').disabled = !name;
    }

    function openAddModal() {
        document.getElementById(nameInputId).value = '';

        // Disable the "Add Student" button initially
        document.getElementById('add-subject-btn').disabled = true;

        // Add event listeners to track changes
        document.getElementById(nameInputId).addEventListener('input', checkAddForm);

        var addModal = new bootstrap.Modal(document.getElementById('addModal'));
        addModal.show();
    }

    function closeAddModal() {
        var addModal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
        addModal.hide();
    }

    const submitCreateSubject = async () => {
        let subjectName = document.getElementById(nameInputId).value;

        var data = {
            name: subjectName,
        };

        let endpoint = 'app/apis/subject.php'
        response = await httpMixin.postMixin(endpoint, data)
        if (response.status == 'succsess') {
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
    })


    // ** Edit Modal Form ** //

    const submitEditSubject = async () => {
        console.log('triggered submitEditSubject')
        let id = document.getElementById('input_target_id').value;
        let subjectName = document.getElementById('edit_name').value;

        var data = {
            id: id,
            name: subjectName,
        };

        let endpoint = 'app/apis/subject.php'
        response = await httpMixin.putMixin(endpoint, data)
        if (response.status == 'succsess') {
            snackBar.showMessage('Thêm môn học thành công')
        } else {
            snackBar.showMessage(response.message ?? 'Thêm môn học thất bại', 'danger')
        }
    }



    const testEdit = () => {
        console.log('testing...')
    }

    const actions = [{
            label: 'Edit',
            className: 'btn-warning',
            handler: (rowData) => {
                console.log(rowData.id)
            }
        },
        {
            label: 'Delete',
            className: 'btn-danger',
            handler: (rowData) => {
                console.log(rowData.id)
            }
        }
    ];

    const tableMixin = new TableMixin(data, 5, ['id', 'name'], actions);
    tableMixin.render(document.getElementById('table-container'));
</script>