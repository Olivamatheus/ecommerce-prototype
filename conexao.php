<?php

$servername = "localhost";  
$username = "root"; 
$password = "";  
$dbname = "e-commerce";  

// Criar a conexão com o MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se houve erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
} else {
    // echo "Conexão bem-sucedida!";
}
?>