<?php
session_start();

$id = (int)($_GET['id'] ?? 0);
$action = $_GET['action'] ?? '';

if (!isset($_SESSION['cart'][$id])) {
    header("Location: cart.php");
    exit;
}

if ($action == 'plus') {
    $_SESSION['cart'][$id]++;
}

if ($action == 'minus') {
    $_SESSION['cart'][$id]--;

    if ($_SESSION['cart'][$id] <= 0) {
        unset($_SESSION['cart'][$id]);
    }
}

header("Location: ../cart.php");
exit;