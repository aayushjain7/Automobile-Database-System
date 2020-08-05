<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc1', 'aayu', 'zzz');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>