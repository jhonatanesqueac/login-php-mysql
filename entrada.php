<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida</title>
</head>
<body>
    <h2>¡Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Has iniciado sesión correctamente.</p>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
