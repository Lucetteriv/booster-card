<?php

namespace App\Auth;

class LogOutUser{

    public static function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }

        // Vider toutes les variables de session
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();

        header("Location:../../public/index.php");
        exit();
    }
};

$LogOutUser = new LogOutUser();
$LogOutUser->logout();
?>