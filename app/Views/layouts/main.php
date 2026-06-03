<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'EduFile', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1E2A38;
            color: #ffffff;
        }

        .sidebar {
            background-color: #000;
            min-width: 250px;
            min-height: 100vh;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar .nav-link {
            color: #ffffff;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 5px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #3498db;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

        .panel {
            background: #2C3E50;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table thead th {
            background-color: #34495E;
            color: #ECF0F1;
            border-bottom: 2px solid #1E2A38;
        }

        .table tbody td {
            background-color: #3E4A59;
            color: #ECF0F1;
            border-bottom: 1px solid #2C3E50;
        }
    </style>
</head>
<body>
    <?php require __DIR__ . '/sidebar.php'; ?>

    <main class="main-content">
        <?= $content ?>
    </main>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
