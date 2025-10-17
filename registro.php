<?php
// Mostrar errores de PHP para facilitar la depuración durante el desarrollo.
ini_set('display_errors', 1); // Activa la visualización de errores.
ini_set('display_startup_errors', 1); // Activa la visualización de errores al iniciar PHP.
error_reporting(E_ALL); // Reporta todos los errores.

require_once 'db.php'; // Se incluye el archivo de configuración de la base de datos.

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica si el método HTTP es POST (envío de un formulario).
    // Recibe y limpia los datos de la solicitud POST.
    $username = trim($_POST['username']); // Elimina espacios en blanco antes y después del nombre de usuario.
    $password = $_POST['password']; // Recibe la contraseña directamente.

    // Verifica que ambos campos estén completos.
    if (empty($username) || empty($password)) {
        die("Por favor completa todos los campos."); // Si falta algún campo, muestra un mensaje y termina la ejecución.
    }

    try {
        // Preparar la consulta SQL para verificar si el nombre de usuario ya existe.
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]); // Ejecuta la consulta con el nombre de usuario.

        // Si el usuario ya existe, muestra un mensaje y termina la ejecución.
        if ($stmt->fetch()) {
            die("El usuario ya existe."); // Si el nombre de usuario ya existe, muestra un mensaje y termina.
        }

        // hace Hashing (convierte los datos a una cadena alfanumerica) de la contraseña antes de almacenarla en la base de datos.
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Cifra la contraseña usando el algoritmo de hashing por defecto.

        // Preparar la consulta SQL para insertar un nuevo usuario en la base de datos.
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        // Ejecuta la consulta de inserción con el nombre de usuario y la contraseña cifrada.
        $result = $stmt->execute([
            'username' => $username,
            'password' => $hashedPassword
        ]);

        // Verifica si la inserción fue exitosa y muestra el mensaje adecuado.
        if ($result) {
            echo "Usuario registrado con éxito."; // Si se insertó correctamente, muestra un mensaje.
        } else {
            echo "Falló el registro."; // Si hubo un error al insertar, muestra un mensaje de error.
        }
    } catch (PDOException $e) {
        // Captura cualquier error relacionado con la base de datos.
        echo "Error en la base de datos: " . $e->getMessage(); // Muestra el mensaje de error.
    }
} else {
    echo "Método no permitido."; // Si no es una solicitud POST, muestra un mensaje de error.
}
