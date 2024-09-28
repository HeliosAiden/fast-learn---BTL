<div class="d-flex">

    <!-- Page Content -->
    <div id="content" class="p-4">
        <div id="mainContent">
            <?php
            // Load the main data from /$__controller/$__action with $data from $data['data']
            $this->render($data['dir'], $data);
            ?>
        </div>
    </div>

</div>