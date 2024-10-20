<div
    class="modal fade"
    id="remove-user-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="remove-modal-value">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">Remove</span>
                    <span class="fw-light">student</span>
                </h5>
                <button
                    type="button"
                    class="close close_remove_modal"
                    data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="small">
                    Bạn chuẩn bị xóa người dùng sau:
                </p>
                <p>Username: <span id="remove-modal-value-username"></span></p>
                <p>Email: <span id="remove-modal-value-email"></span></p>
                <p class="small">
                    Bạn có muốn tiếp tục ?
                </p>
            </div>
            <div class="modal-footer border-0">
                <button
                    type="button"
                    id="remove-user-btn"
                    class="btn btn-success">
                    Có
                </button>
                <button
                    type="button"
                    class="btn btn-danger close_remove_modal"
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

    function closeRemoveModal() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('remove-user-modal'));
        modal.hide()
    }

    const handleRemoveUser = async () => {
        let url = 'app/apis/user.php'
        let data = {
            state: 'Removed'
        }
        let id = document.getElementById('remove-modal-value').value
        const response = await httpMixin.putMixin(url, data, id)
        if (response.status == 'success') {
            swal({
                title: "Xóa người dùng thành công!",
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
            closeRemoveModal()
            window.location.reload()
        } else {
            swal(response.message ?? "Xóa người dùng thất bại!", {
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
        document.getElementById('remove-user-btn').addEventListener('click', handleRemoveUser)
        document.querySelectorAll('.close_remove_modal').forEach(btn => {
            btn.addEventListener('click', closeRemoveModal)
        })
    });
</script>