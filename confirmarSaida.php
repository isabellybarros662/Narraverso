<?php
session_start();
$_SESSION['confirmarSaida'] = true; // ← Flag para exibir modal
header("Location: configuracoes.php");
exit;
?>