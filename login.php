<?php
include 'conexao.php';

// Captura os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Prepara a consulta para buscar o usuário com o e-mail fornecido
$sql = "SELECT * FROM users WHERE user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se o usuário existe
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verifica se a senha está correta
    if ($user['user_senha']) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];

        // Redireciona o usuário conforme o papel (vendedor ou cliente)
        if ($user['role'] == 'seller') {
            header("Location: /DEV-PHP/loja-II/products/index.php");
        } else {
            header("Location: /DEV-PHP/loja-II/showcase/index.php"); 
        }
        exit();
    } else {
        echo "<script>alert('Senha incorreta!'); window.location.href = 'index.php';</script>";
    }
} else {
    echo "<script>alert('Usuário não encontrado!'); window.location.href = 'index.php';</script>";
}

$conn->close();
?>