<?php
session_start(); // Para poder usar sesiones

require_once 'db.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        die("❌ Por favor completa todos los campos.");
    }

    try {
        // Busca los usuario por nombre
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // guardar sesión
            $_SESSION['username'] = $username;
            echo "✅ Bienvenido, " . htmlspecialchars($username) . ". Has iniciado sesión.";
            // redirigir a entrada.php:
             header("Location: entrada.php");
             exit;
        } else {
            echo "❌ Usuario o contraseña incorrectos.";
        }

    } catch (PDOException $e) {
        echo "🔥 Error de base de datos: " . $e->getMessage();
    }
} else {
    echo "Método no permitido.";
}
