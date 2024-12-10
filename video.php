<?php
// video.php
require_once 'config.php';

$sessionToken = '';

// Función para hacer login y obtener el token de sesión
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

        if ($responseData['result'] === 0) {
            $sessionToken = $responseData['jsession'] ?? $responseData['JSESSIONID'];
            echo "Inicio de sesión exitoso. Token de sesión: " . $sessionToken;
        } else {
            echo "Error al iniciar sesión: " . print_r($responseData, true);
        }
    } else {
        echo "Error al realizar la solicitud de inicio de sesión.";
    }
}

if (!isset($_GET['devIdno'])) {
    echo '<p class="error">Device ID is required!</p>';
    exit;
}

$devIdno = $_GET['devIdno'];

// Si la sesión no ha sido iniciada, realizar login
if (empty($sessionToken)) {
    login();
}

// Construir la URL del video con el devIdno y el sessionToken
$videoUrl = "http://dvr02.dashcam.pe/808gps/open/player/video.html?lang=en&devIdno=$devIdno&jsession=$sessionToken";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video for Device ID: <?php echo htmlspecialchars($devIdno); ?></title>
</head>
<body>
    <h2>Video for Device ID: <?php echo htmlspecialchars($devIdno); ?></h2>
    <iframe src="<?php echo $videoUrl; ?>" width="800" height="600"></iframe>
</body>
</html>
