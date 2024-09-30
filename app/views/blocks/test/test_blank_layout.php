<div class="d-flex">

    <!-- Page Content -->
    <div id="content" class="container" style="height: 100vh">
        <div id="mainContent" class="row">
            <?php
            // Load the main data from /$__controller/$__action with $data from $data['data']
            $this->render($data['dir'], $data);
            ?>
        </div>
    </div>

</div>