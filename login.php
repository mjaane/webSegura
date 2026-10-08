<?php
session_start();
require 'db.php'; // Nos conectamos a la BD
$error = '';

// Si el usuario envía el formulario de login...
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Buscamos al usuario en la BD usando consultas preparadas (evita Inyección SQL)
    $stmt = $pdo->prepare("SELECT password FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC); // Extraemos la fila de la BD

    // SEGURIDAD: password_verify compara la contraseña plana escrita con el hash guardado de forma segura.
    // Si el usuario existe ($row) y la contraseña coincide...
    if ($row && password_verify($password, $row['password'])) {
        // Creamos una variable de sesión con su email. ¡El usuario ya está logueado oficialmente!
        $_SESSION['usuario'] = $email; 
        header("Location: perfil.php"); // Lo llevamos a su zona privada
        exit;
    } else {
        // SEGURIDAD: Mensaje de error genérico. 
        // No decimos "el email no existe" ni "contraseña incorrecta" para no dar pistas a los atacantes 
        // sobre qué correos están registrados en el sistema (evita enumeración de usuarios).
        $error = "Credenciales incorrectas";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h2>Login</h2>
    <form method="POST">
        Email: <input type="email" name="email" required><br><br>
        Contraseña: <input type="password" name="password" required><br><br>
        <button type="submit">Entrar</button>
    </form>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <a href="index.php">Volver</a>
</body>
</html>