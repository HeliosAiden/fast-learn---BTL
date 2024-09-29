<div class="d-flex">
    <?php $this->render('blocks/test/test_header'); ?>

    <!-- Page Content -->
    <div id="snackbar-container">
        <div id="content" class="p-4">
            <div id="mainContent">
                <?php
                // Load the main data from /$__controller/$__action with $data from $data['data']
                $this->render($data['dir'], $data);
                ?>
            </div>
        </div>
    </div>

    <button id="sidebarToggle">
        <i class="fas fa-bars"></i> <!-- Icon for open state -->
    </button>

</div>
<script>
    // Toggle Sidebar
    document.getElementById("sidebarToggle").addEventListener("click", function() {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("active");

        // Change Icon when sidebar is toggled
        const toggleIcon = this.querySelector("i");
        if (sidebar.classList.contains("active")) {
            toggleIcon.classList.remove("fa-bars");
            toggleIcon.classList.add("fa-times"); // Icon for closed state
        } else {
            toggleIcon.classList.remove("fa-times");
            toggleIcon.classList.add("fa-bars"); // Icon for open state
        }
    });

    // Folder collapse/expand functionality
    const folders = document.querySelectorAll(".folder-toggle");
    folders.forEach((folder) => {
        folder.addEventListener("click", function() {
            const folderContent = this.nextElementSibling;
            folderContent.style.display =
                folderContent.style.display === "none" ||
                folderContent.style.display === "" ?
                "block" :
                "none";
        });
    });
</script>