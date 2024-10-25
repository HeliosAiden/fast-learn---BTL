<!-- Delete Course Lesson Modal -->
<div class="modal" id="delete-lesson-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa khóa học</h5>
                <button type="button" class="btn-close close-delete-modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc muốn xóa bài học này ?</p>
                <input type="hidden" id="delete-lesson-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-delete-modal">Hủy</button>
                <button type="button" id="delete-lesson-btn" class="btn btn-danger">Xóa</button>
            </div>
        </div>
    </div>
</div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import SnackBarMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/snackbar.js' ?>";
    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

    const handleDeleteLesson = async () => {
        let url = 'app/apis/course_lesson.php'
        let id = document.getElementById('delete-lesson-id').value
        const response = await httpMixin.deleteMixin(url, id)
        if (response.status == 'success') {
            swal({
                title: "Xóa bài học thành công!",
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
            window.location.reload()
        } else {
            swal(response.message ?? "Xóa bài học thất bại!", {
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

    const closeDeleteModal = () => {
        var deleteModal = bootstrap.Modal.getInstance(document.getElementById('delete-lesson-modal'));
        deleteModal.hide()
    }

    $(document).ready(function() {
        document.querySelectorAll('.close-delete-modal').forEach(btn => {
            btn.addEventListener('click', closeDeleteModal)
        })
        document.getElementById('delete-lesson-btn').addEventListener('click', () => {
            handleDeleteLesson()
            closeDeleteModal()
        })
    })

</script>