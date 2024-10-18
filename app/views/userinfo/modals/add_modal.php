<!-- Add User Info Modal -->
<div class="modal" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm khóa học</h5>
                <button type="button" class="btn-close close_add_modal"></button>
            </div>
            <div class="modal-body">
                <!-- Course Name (Required) -->
                <div class="mb-3">
                    <label for="user_info_add_firstname" class="form-label">Tên<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="user_info_add_firstname" name="user_info_add_firstname" required>
                    <div class="invalid-feedback">
                        Vui lòng cung cấp tên của bạn
                    </div>
                </div>

                <!-- Course Description (Optional) -->
                <div class="mb-3">
                    <label for="user_info_add_lastname" class="form-label">Họ</label>
                    <input type="text" class="form-control" id="user_info_add_lastname" name="user_info_add_lastname" required></input>
                    <div class="invalid-feedback">
                        Vui lòng cung họ của bạn
                    </div>
                </div>

                <!-- Course Fee (Optional) -->
                <div class="mb-3">
                    <label for="user_info_add_phone_number" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="user_info_add_phone_number" name="user_info_add_phone_number">
                </div>

                <!-- Subject ID (Required) -->
                <div class="mb-3">
                    <label for="user_info_add_gender" class="form-label">Giới tính <span class="text-danger">*</span></label>
                    <select class="form-select" id="user_info_add_gender" name="user_info_add_gender" required>
                        <option value="" disabled selected>Chọn giới tính</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="user_info_add_dob" class="form-label">Ngày - tháng - năm sinh</label>
                    <input type="date" class="form-control" id="user_info_add_dob" name="user_info_add_dob">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_add_modal">Đóng</button>
                <button type="button" id="add_course" class="btn btn-success">Tạo thông tin người dùng</button>
            </div>
        </div>
    </div>
</div>
<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    import SnackBarMixin from "<?php echo _WEB_ROOT . '/public/assets/js/components/snackbar.js' ?>";
    const snackBar = new SnackBarMixin()

    const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')

    function openAddModal() {
        document.getElementById("user_info_add_firstname").value = '';

        let selectElement = document.getElementById('user_info_add_gender')
        const genders = ['Male', 'Female', 'Others']
        genders.forEach(value => {
            let option = document.createElement('option')
            let id = `gender-${value}`
            option.value = value
            let label = ''
            switch(value) {
                case 'Male':
                    label = 'Nam'
                    break
                case 'Female':
                    label = 'Nữ'
                    break
                case 'Others':
                    label = 'Giới tính khác'
                    break
                default:
                    label = 'Không xác định'
                    break
            }
            option.innerHTML = label
            if (!selectElement.querySelector(`#${id}`)) {
                selectElement.appendChild(option)
            }
        });

        var addModal = new bootstrap.Modal(document.getElementById('addModal'));
        addModal.show();
    }

    function closeAddModal() {
        var addModal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
        addModal.hide();
    }

    const submitCreateCourse = async () => {
        let firstname = document.getElementById("user_info_add_firstname").value;
        let lastname = document.getElementById("user_info_add_lastname").value;
        let phone_number = document.getElementById("user_info_add_phone_number").value;
        let gender = document.getElementById("user_info_add_gender").value;
        let dob = document.getElementById("user_info_add_dob").value;

        var data = {
            firstname: firstname ?? '',
            lastname: lastname ?? '',
            phone_number: phone_number ?? '',
            gender: gender ?? null,
            date_of_birth: dob ?? null,
        };

        let endpoint = 'app/apis/user_info.php'
        const response = await httpMixin.postMixin(endpoint, data)
        if (response.status == 'success') {
            snackBar.showMessage('Thêm thông tin người dùng thành công')
        } else {
            snackBar.showMessage(response.message ?? 'Thêm thông tin người dùng thất bại', 'danger')
        }
    }

    document.getElementById('open_add_modal').addEventListener('click', openAddModal)
    document.querySelectorAll('.close_add_modal').forEach(btn => {
        btn.addEventListener('click', closeAddModal)
    })
    document.getElementById('add_course').addEventListener('click', () => {
        closeAddModal()
        submitCreateCourse()
        // window.location.reload();
    })
</script>