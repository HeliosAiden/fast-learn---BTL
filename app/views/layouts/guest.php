<?php
    // Base layout of client side, content rendered through $data is considered a seperate file

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <title><?php echo (!empty($page_title)) ? $page_title : 'Fast learn' ?></title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/css/style.css" />
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo _WEB_ROOT; ?>/public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo _WEB_ROOT; ?>/public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Landing Page CSS -->
    <link rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/css/landing.css" />
</head>

<body>
    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Jquery Script -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Custom Script -->
    <script type="text/javascript" src="<?php echo _WEB_ROOT; ?>/public/assets/js/script.js"></script>

    <?php
    // $this->render('blocks/guest/spinner', $data);
    $this->render('blocks/guest/navbar', $data);
    $this->render('blocks/guest/carrousel', $data);
    $this->render('blocks/guest/service', $data);
    $this->render('blocks/guest/about', $data);
    $this->render('blocks/guest/category', $data);
    $this->render('blocks/guest/courses', $data);
    $this->render('blocks/guest/team', $data);
    $this->render('blocks/guest/testimonial', $data);
    $this->render('blocks/guest/footer', $data);
    $this->render('blocks/guest/utils', $data);
    ?>

</body>

</html>