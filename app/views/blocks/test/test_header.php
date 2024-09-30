<div id="sidebar" class="bg-dark d-flex flex-column justify-content-between vh-100">
    <div class="container">
        <a class="nav-link" href="<?php echo __URL_ORIGIN__ ?>/user/">
            <h3 class="text-center py-3">Menu</h3>
        </a>
        <ul class="nav flex-column">
            <li class="nav-item">
                <span class="nav-link folder-toggle"><i class="fa-regular fa-user me-2"></i>Người dùng</span>
                <ul class="folder-content">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo __URL_ORIGIN__ ?>/user/list/">Liệt kê</a>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo __URL_ORIGIN__ ?>/subject/"><i class="fa-solid fa-book me-2"></i>Môn học</a>
            </li>
        </ul>
    </div>
    <div class="p-3">
        <button id="logoutButton" type="submit" class="btn btn-danger w-100">Logout</button>
    </div>
</div>

<script type="module">
    import HttpMixin from "<?php echo _WEB_ROOT . '/public/assets/js/api/httpMixin.js' ?>";
    const logoutUrl = "<?php echo _WEB_ROOT . '/user/login' ?>";

    const logoutButton = document.getElementById('logoutButton')
    const handleLogout = () => {
        const httpMixin = new HttpMixin('<?php echo _WEB_ROOT ?>')
        let url = '/app/apis/logout.php'
        httpMixin.postMixin(url)
        window.location.href = logoutUrl
    }
    logoutButton.addEventListener('click', handleLogout)
</script>