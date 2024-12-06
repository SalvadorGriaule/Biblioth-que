<?php
$pdo = new PDO("mysql:host=localhost;dbname=entreprise","root2","pass");

$read = $pdo->query('SELECT * FROM employes');
$result = $read->fetchAll();
