<?php
// video.php
require_once 'config.php';

$sessionToken = '';

function login() {
    global $sessionToken;

    $apiBaseUrl = $_ENV['API_BASE_URL'];
    $loginEndpoint = $_ENV['LOGIN_ENDPOINT'];
    $username = $_ENV['USERNAME'];
    $password = $_ENV['PASSWORD'];

    $url = $apiBaseUrl . $loginEndpoint;
    $data = [
        'account' => $username,
        'password' => $password
    ];

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data)
        ]
    ];

    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response !== false) {
        $responseData = json_decode($response, true);
        if (isset($responseData['result']) && $responseData['result'] === 0) {
            $sessionToken = $responseData['jsession'] ?? $responseData['JSESSIONID'];
        } else {
            echo "Error al iniciar sesión: " . print_r($responseData, true);
            exit;
        }
    } else {
        echo "Error al realizar la solicitud de inicio de sesión.";
        exit;
    }
}

if (!isset($_GET['devIdno'])) {
    echo '<p class="error">Device ID is required!</p>';
    exit;
}

$devIdno = $_GET['devIdno'];

if (empty($sessionToken)) {
    login();
}

$videoUrl1 = "http://dvr02.dashcam.pe/808gps/open/player/video.html?lang=en&devIdno=$devIdno&jsession=$sessionToken&channel=1&chns=1,1,2";
$videoUrl2 = "http://dvr02.dashcam.pe/808gps/open/player/video.html?lang=en&devIdno=$devIdno&jsession=$sessionToken&channel=1&chns=0,1,2";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Videos for Device ID: <?php echo htmlspecialchars($devIdno); ?></title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Incluimos el archivo CSS -->
</head>
<body class="video-body">
    <header>
        <h1>Device ID: <?php echo htmlspecialchars($devIdno); ?></h1>
    </header>
    <main>
        <h2>Visualización de Videos</h2>
        <div class="video-container">
            <div class="video-box">
                <div class="video-title">Video 1</div>
                <div class="iframe-wrapper">
                    <iframe src="<?php echo $videoUrl1; ?>"></iframe>
                </div>
            </div>
            <div class="video-box">
                <div class="video-title">Video 2</div>
                <div class="iframe-wrapper">
                    <iframe src="<?php echo $videoUrl2; ?>"></iframe>
                </div>
            </div>
        </div>
    </main>
    <!-- <footer>
        &copy; <?php echo date('Y'); ?> Sistema de Videos - Todos los derechos reservados.
    </footer> -->
</body>
</html>

<!-- php -S localhost:8000 -->