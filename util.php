<?php
ini_set("session.cookie_lifetime", "60");
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
/* Orden 1 */

function existeUser(string $user, array $usuarios): bool {
    return array_key_exists($user, $usuarios);
}

/* Orden 2 */

function login(string $user, string $pwd, array $usuarios): bool {
    return $usuarios[$user]["pwd"] === $pwd;
}

function cerrarSesion() {

    iniciarSesion();

    session_destroy();

    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
        );
    }
}

function isUserLoggedIn() {
    return $autenticado = iniciarSesion() && (session_status() === PHP_SESSION_ACTIVE) && isset($_SESSION["user"]);
}

function iniciarSesion(): bool {
    $iniciada = true;
    if (session_status() !== PHP_SESSION_ACTIVE) {
        $iniciada = session_start();
    }
    
    return $iniciada;
}
