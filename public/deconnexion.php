<?php

require_once __DIR__ . '/../autoload.php';
SessionManager::start();
SessionManager::remove('logged_in');
SessionManager::remove('connected_user');

header('Location: connexion.php');
exit;
