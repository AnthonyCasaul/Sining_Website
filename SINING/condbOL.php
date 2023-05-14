<?php

$server = "localhost";
$user = "id20549869_admin";
$pass = "k8qy(kmk[Auaka05";
$database = "id20549869_jcrasining";

$conn = new Mysqli($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>