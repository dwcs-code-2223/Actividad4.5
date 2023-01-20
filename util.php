<?php

CONST MAX_SECONDS_INACTIVITY = 600;
ini_set("session.cookie_lifetime", "600");

const ADMIN_ROLE = "admin";
const USER_ROLE = "user";
$app_roles = [ADMIN_ROLE, USER_ROLE];
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
    return password_verify($pwd, $usuarios[$user]["pwd"]);
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
    $autenticado = iniciarSesion() && (session_status() === PHP_SESSION_ACTIVE) && isset($_SESSION["user"]);
    return $autenticado && isUserActive();
}

function isUserActive(): bool {
    $active = false;
    $actual_time = time();
    $diff = $actual_time - $_SESSION["ultimoAcceso"];
    if ($diff < MAX_SECONDS_INACTIVITY) {
        $active = true;
    } else {
        cerrarSesion();
    }

    return $active;
}

function iniciarSesion(): bool {
    $iniciada = true;
    if (session_status() !== PHP_SESSION_ACTIVE) {
        $iniciada = session_start();
    }

    return $iniciada;
}

function isUserInRoleId(string $user, int $roleId, array $usuarios) {
    global $app_roles;
    $roleName = $app_roles[$roleId];

    $resultado = in_array($roleName, $usuarios[$user]["roles"]);
    return $resultado;
}

function isUserAllowedInPage(array $page_roles):bool {
    global $app_roles;
    $roleId = $_SESSION["roleId"];
    $roleName = $app_roles[$roleId];
    return in_array($roleName, $page_roles);
}
