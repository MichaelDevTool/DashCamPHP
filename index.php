<?php
// index.php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Video System</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Incluimos el archivo CSS -->
</head>
<body class="login-body">
    <div class="login-container">
        <h1>Sistema de Videos</h1>
        <form action="video.php" method="get">
            <div class="form-group">
                <label for="devIdno">Device ID:</label>
                <input type="text" id="devIdno" name="devIdno" placeholder="Ingrese el Device ID" required>
            </div>
            <button type="submit">Ver Videos</button>
        </form>
        <footer>
            &copy; <?php echo date('Y'); ?> Sistema de Videos
        </footer>
    </div>
</body>
</html>

