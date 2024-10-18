<h2 class="text-center mb-4">Danh sách thông tin người dùng</h2>
<div class="text-end mb-3">
    <button id='open_add_modal' class='btn btn-primary'>Thêm thông tin người dùng</button>
</div>
<?php
// If user is admin then show user_info table
// If not, only show user info
$role = $this->get_user_role();
require_once __DIR__ . '/modals/add_modal.php';

if ($role !== 'Admin') {
    echo '<div class="container mt-5">
            <div id="user-info-card"></div>
          </div>';
    require_once __DIR__ . '/user.php';
} else {
    echo '<div class="container mt-5">
            <div id="table-container"></div>
          </div>';
    require_once __DIR__ . '/admin.php';
}
?>