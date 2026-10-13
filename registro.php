<?php
session_start(); // Iniciamos el sistema de sesiones
require 'db.php'; // Importamos la conexión a la base de datos
$error = ''; // Variable para guardar mensajes de error

// Comprobamos si el usuario ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recogemos el email y contraseña. Si están vacíos, asignamos texto en blanco ('')
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validación de entrada. Evitamos contraseñas débiles o vacías.
    if (strlen($password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres.";
    } else {
        //  Transforma "12345678" en un texto largo e ilegible ($2y$10$...).
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            // Consultas preparadas. Usamos '?' en lugar de poner las variables directamente.
            $stmt = $pdo->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
            // Sustituimos los '?' de forma segura por el email y el hash
            $stmt->execute([$email, $hash]);
            
            // Si el registro funciona, redirigimos al usuario a la página de login
            header("Location: login.php");
            exit; 
        } catch (PDOException $e) {
            // Si falla (ej. el correo ya existe por la regla UNIQUE de la BD), mostramos error
            $error = "Este correo ya está registrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h2>Registro</h2>
    <form method="POST">
        Email: <input type="email" name="email" required><br><br>
        Contraseña: <input type="password" name="password" required><br><br>
        <button type="submit">Registrar</button>
    </form>
    <!-- SEGURIDAD: htmlspecialchars() convierte caracteres especiales en texto inofensivo.
         Evita ataques XSS (Cross-Site Scripting) si el error contuviera código HTML/JS malicioso. -->
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <a href="index.php">Volver</a>
</body>
</html>