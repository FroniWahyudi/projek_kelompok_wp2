<?php
$conn = new mysqli("localhost", "root", "", "naga_hytam");
$id = $_GET['id'];
$conn->query("DELETE FROM laporan_kerja WHERE id = $id");
header("Location: laporan_kerja.php");
?>
