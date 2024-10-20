<?php
$students = $this->get_users_with_condition(['role' => 'Student'], ['id', 'username', 'email', 'state'], ['state' => 'Removed']);

?>

<div class="container">
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Danh sách học sinh</h4>
                </div>
            </div>
            <div class="card-body">

                <!-- Active User state modal -->
                <?php require_once __DIR__ . '/modals/active_state.php' ?>
                <script>
                    function openActiveModal(button, attr = 'data-user-id') {
                        let user_id = button.getAttribute(attr)
                        document.getElementById('active-modal-value').value = user_id

                        const modal = new bootstrap.Modal(document.getElementById('active-user-modal'));
                        modal.show()
                    }
                </script>

                <!-- Lock User state modal -->
                <?php require_once __DIR__ . '/modals/lock_state.php' ?>
                <script>
                    function openLockModal(button, attr = 'data-user-id') {
                        let user_id = button.getAttribute(attr)
                        document.getElementById('lock-modal-value').value = user_id

                        const modal = new bootstrap.Modal(document.getElementById('lock-user-modal'));
                        modal.show()
                    }
                </script>

                <!-- Remove User modal -->
                <?php require_once __DIR__ . '/modals/remove.php' ?>
                <script>
                    function openRemoveModal(button, attr = 'data-user-id') {
                        let user_id = button.getAttribute(attr)
                        let user_username = button.getAttribute('data-user-username')
                        let user_email = button.getAttribute('data-user-email')

                        document.getElementById('remove-modal-value').value = user_id
                        document.getElementById('remove-modal-value-username').innerHTML = user_username
                        document.getElementById('remove-modal-value-email').innerHTML = user_email

                        const modal = new bootstrap.Modal(document.getElementById('remove-user-modal'));
                        modal.show()
                    }
                </script>


                <div class="table-responsive">
                    <table
                        id="student-table"
                        class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="sorting">Tên đăng nhập</th>
                                <th class="sorting">Email</th>
                                <th class="sorting">Trạng thái</th>
                                <th style="width: 10%">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($students)) {
                                foreach ($students as $row) {
                                    $state_str = '';
                                    switch ($row['state']) {
                                        case 'Inactive':
                                            $state_str = 'Chưa kích hoạt';
                                            break;
                                        case 'Active':
                                            $state_str = 'Đã kích hoạt';
                                            break;
                                        case 'Locked':
                                            $state_str = 'Bị khóa';
                                            break;
                                        default:
                                            $state_str = 'Không xác định';
                                            break;
                                    }
                                    echo '
                                <tr>
                                    <td>' . $row['username'] . '</td>
                                    <td>' . $row['email'] . '</td>
                                    <td>' . $state_str . '</td>
                                    <td>
                                        <div class="form-button-action">
                                            <button
                                                type="button"
                                                data-bs-toggle="tooltip"
                                                class="btn btn-link btn-primary btn-lg"
                                                data-original-title="Enable user"
                                                data-user-id="' . $row['id'] . '"
                                                onclick="openActiveModal(this)"
                                                >
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                            <button
                                                type="button"
                                                data-bs-toggle="tooltip"
                                                class="btn btn-link btn-warning"
                                                data-original-title="Lock User"
                                                data-user-id="' . $row['id'] . '"
                                                onclick="openLockModal(this)"
                                                >
                                                <i class="fas fa-user-lock"></i>
                                            </button>
                                            <button
                                                type="button"
                                                data-bs-toggle="tooltip"
                                                class="btn btn-link btn-danger"
                                                data-original-title="Remove User"
                                                data-user-id="' . $row['id'] . '"
                                                data-user-username="' . $row['username'] . '"
                                                data-user-email="' . $row['email'] . '"
                                                onclick="openRemoveModal(this)"
                                                >
                                                <i class="fas fa-user-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                ';
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="module">
    $(document).ready(function() {
        // Add Row
        $("#student-table").DataTable({
            pageLength: 5,
        });
    });

    function testButton(button, attr = 'data-user-id') {
        let user_id = button.getAttribute(attr)
        console.log("user id: " + user_id)
    }
</script>