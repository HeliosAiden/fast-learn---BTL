<div
    class="modal fade"
    id="active-user-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="active-modal-value">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <span class="fw-mediumbold"> Active</span>
                    <span class="fw-light"> user </span>
                </h5>
                <button
                    type="button"
                    class="close close_active_modal"
                    data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">
                    Đổi trạng thái của người dùng thành <b>Đã kích hoạt</b>
                </p>
                <p class="small">
                    Bạn có muốn tiếp tục ?
                </p>
            </div>
            <div class="modal-footer border-0">
                <button
                    type="button"
                    id="change-student-state--active-btn"
                    class="btn btn-success">
                    Có
                </button>
                <button
                    type="button"
                    class="btn btn-danger close_active_modal"
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

    function closeActiveModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('active-user-modal'));
        modal.hide()
    }

    const handleChangeStudentStateActive = async () => {
        let url = '/app/apis/user.php'
        let data = {
            state: 'Active'
        }
        let id = document.getElementById('active-modal-value').value
        const response = await httpMixin.putMixin(url, data, id)
        console.log(response)
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
            closeActiveModal()
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
        document.getElementById('change-student-state--active-btn').addEventListener('click', handleChangeStudentStateActive)
        document.querySelectorAll('.close_active_modal').forEach(btn => {
            btn.addEventListener('click', closeActiveModal)
        })
    });
</script>