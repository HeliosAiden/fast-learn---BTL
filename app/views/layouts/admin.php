<!DOCTYPE html>
<html lang="en">

<head>
  <meta
    content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    name="viewport" />
  <!-- Fonts and icons -->
  <script src="<?php echo _WEB_ROOT ?>/public/assets/admin/js/plugin/webfont/webfont.min.js"></script>
  <title><?php echo (!empty($page_title)) ? $page_title : 'Fast learn' ?></title>
  <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["<?php echo _WEB_ROOT ?>/public/assets/admin/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/admin/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/admin/css/plugins.min.css" />
  <link rel="stylesheet" href="<?php echo _WEB_ROOT ?>/public/assets/admin/css/kaiadmin.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

</head>

<body>
  <div class="wrapper">
    <?php
    $this->render('blocks/admin/utils', $data);
    ?>
    <?php
    $this->render('blocks/admin/sidebar', $data);
    ?>
    <!-- $this->render('blocks/admin/main_panel', $data); -->
    <div class="main-panel">
      <?php $this -> render('blocks/admin/main_header') ?>
      <?php
      if ($data['dir'] == 'home/index') {
        $this -> render('blocks/admin/main_container');
      } else {
        $this->render($data['dir'], $data);
      };
      ?>
      <?php $this -> render('blocks/admin/main_footer') ?>
    </div>
  </div>
</body>

</html>