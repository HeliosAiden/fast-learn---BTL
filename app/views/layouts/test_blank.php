<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (!empty($page_title)) ? $page_title : 'default web name' ?></title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/css/blank.css" />
</head>

<body>
    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Jquery Script -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Custom Script -->
    <script type="text/javascript" src="<?php echo _WEB_ROOT; ?>/public/assets/js/script.js"></script>
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/core/popper.min.js"></script>
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/kaiadmin.min.js"></script>
    <?php
    $this->render('blocks/test/test_blank_layout', $data);
    ?>


</body>

</html>