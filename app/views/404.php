<?php
// Set the HTTP response status code to 404
http_response_code(404);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .container {
            max-width: 600px;
        }

        .error-message {
            font-size: 2rem;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #6861CE !important;
            border-color: #6861CE !important;
        }
    </style>
</head>

<body>
    <div class="page-inner">
        <div class="d-flex flex-column align-items-center">
            <img src="<?php echo _WEB_ROOT ?>/public/assets/admin/img/undraw/undraw_not_found_60pq.svg" width="250" alt="Page Not Found">
            <h2 class="h1 mt-4 mb-4 fw-bold">Sorry! page not found.</h2>
            <div>
                <a href="<?php echo _WEB_ROOT ?>/" class="btn btn-primary">GO TO HOME PAGE</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>