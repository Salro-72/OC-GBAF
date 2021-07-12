<?php
function connected(): bool {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['connect']);
}

function force_user_connect (): void {
    if(!connected()); {
        header('Location: login.php');
        exit();
    }
}