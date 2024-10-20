<div
    class="modal fade"
    id="lock-user-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="lock-modal-value">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">Lock</span>
                    <span class="fw-light">student</span>
                </h5>
                <button
                    type="button"
                    class="close close_lock_modal"
                    data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">
                    Đổi trạng thái của học sinh thành <b>Bị khóa</b>
                </p>
                <p class="small">
                    Bạn có muốn tiếp tục ?
                </p>
            </div>
            <div class="modal-footer border-0">
                <button
                    type="button"
                    id="change-student-lock--active-btn"
                    class="btn btn-success">
                    Có
                </button>
                <button
                    type="button"
                    class="btn btn-danger close_lock_modal"
                    data-dismiss="modal">

                    Không
                </button>
            </div>
        </div>
    </div>
</div>

<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>"
    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

    function closeLockModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('lock-user-modal'));
        modal.hide()
    }

    const handleChangeStudentStateLock = async () => {
        let url = '/app/apis/user.php'
        let data = {
            state: 'Locked'
        }
        let id = document.getElementById('lock-modal-value').value
        const response = await httpMixin.putMixin(url, data, id)
        if (response.status == 'success') {
            swal({
                title: "Thay đổi trạng thái của người dùng thành công!",
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
            closeLockModal()
            window.location.reload()
        } else {
            swal(response.message ?? "Thay đổi trạng thái của người dùng không thành công!", {
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

    $(document).ready(function() {
        document.getElementById('change-student-lock--active-btn').addEventListener('click', handleChangeStudentStateLock)
        document.querySelectorAll('.close_lock_modal').forEach(btn => {
            btn.addEventListener('click', closeLockModal)
        })
    });
</script>