<!-- Delete Course Modal -->
<div class="modal" id="delete-course-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa khóa học</h5>
                <button type="button" class="btn-close close-delete-modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc muốn xóa khóa học trên ?</p>
                <p><b>Tên</b>: <span id="delete_course_name"></span></p>
                <p><b>Môn học</b>: <span id="delete_course_subject_name"></span></p>
                <input type="hidden" id="delete_course_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-delete-modal">Hủy</button>
                <button type="button" id="delete-course-btn" class="btn btn-danger">Xóa</button>
            </div>
        </div>
    </div>
</div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

    function closeDeleteModal() {
        var deleteModal = bootstrap.Modal.getInstance(document.getElementById('delete-course-modal'));
        deleteModal.hide();
    }

    const submitDeleteSubject = async () => {
        const id = document.getElementById('delete_course_id').value
        let endpoint = `app/apis/course.php`
        const response = await httpMixin.deleteMixin(endpoint, id)
        if (response.status == 'success') {
            swal({
                title: "Xóa khóa học thành công!",
                icon: "success",
                buttons: {
                    confirm: {
                        text: "Xác nhận",
                        value: true,
                        visible: true,
                        className: "btn btn-success",
                        closeModal: true,
                    },
                },
            });
            closeEditModal()
            window.location.reload()
        } else {
            swal(response.message ?? "Xóa khóa học thất bại!", {
                icon: "error",
                buttons: {
                    confirm: {
                        className: "btn btn-danger",
                        closeModal: true,
                        visible: true
                    },
                },
            });
        }
    }

    document.querySelectorAll('.close-delete-modal').forEach(btn => {
        btn.addEventListener('click', closeDeleteModal)
    })
    document.getElementById('delete-course-btn').addEventListener('click', () => {
        submitDeleteSubject()
    })
</script>