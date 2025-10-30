<?php
function require_login() {
  if (session_status() == PHP_SESSION_NONE) session_start();
  if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
  }
}
function require_admin() {
  if (session_status() == PHP_SESSION_NONE) session_start();
  if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
    header('Location: /public/login.php');
    exit;
  }
}
