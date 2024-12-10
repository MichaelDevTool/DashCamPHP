<?php
// index.php
require_once 'config.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Video System</title>
</head>
<body>
    <h1>Login Video System</h1>
    <form action="video.php" method="get">
        <label for="devIdno">Enter Device ID:</label>
        <input type="text" id="devIdno" name="devIdno" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
