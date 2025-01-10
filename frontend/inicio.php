<?php
header('X-Frame-Options: DENY');

setcookie('panaderia', 'inicio', [
    'expires' => time() + 3600,
    'path' => '/',
    'domain' => '.localhost',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict' // None, Lax or Strict
]);

// Función para encriptar el texto
function encriptarTexto($texto, $clave) {
    // Generar un IV aleatorio
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    // Encriptar el texto
    $textoEncriptado = openssl_encrypt($texto, 'aes-256-cbc', $clave, 0, $iv);

    // Codificar el IV y el texto encriptado en base64 para que se puedan almacenar y mostrar
    return base64_encode($iv . $textoEncriptado);
}

function desencriptarTexto($textoEncriptado, $clave) {
    // Decodificar el texto encriptado y el IV en base64
    $datos = base64_decode($textoEncriptado);

    // Extraer el IV del principio del texto
    $iv = substr($datos, 0, openssl_cipher_iv_length('aes-256-cbc'));

    // Extraer el texto encriptado después del IV
    $textoEncriptado = substr($datos, openssl_cipher_iv_length('aes-256-cbc'));

    // Desencriptar el texto
    return openssl_decrypt($textoEncriptado, 'aes-256-cbc', $clave, 0, $iv);
}

// Inicializar variables
$textoEncriptado = "";
$clave = 'apiPanadeia2025'; // La clave debe ser segura y no predecible

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['texto'])) {
    $texto = $_POST['texto'];
    // Llamar a la función de encriptación
    $textoEncriptado = encriptarTexto($texto, $clave);
    $textoNormal = desencriptarTexto($textoEncriptado, $clave);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<h1>Inicio de sesión</h1>
<form id="loginForm">
    <div>
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Iniciar</button>
</form>
<h2>Formulario de Encriptación de Texto</h2>

<!-- Formulario HTML -->
<form method="POST" action="">
    <label for="texto">Ingresa el texto a encriptar:</label><br>
    <input type="text" id="texto" name="texto"><br><br>
    <button type="submit">Encriptar</button>
</form>

<?php if ($textoEncriptado): ?>
    <h3>Texto encriptado:</h3>
    <p><?php echo htmlspecialchars($textoEncriptado); ?></p>
    <h3>Texto desencriptado:</h3>
    <p><?php echo htmlspecialchars($textoNormal); ?></p>
<?php endif; ?>
<script src="js/scriptsAuth.js"></script>
</body>
</html>