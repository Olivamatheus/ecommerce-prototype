<?php
include '../conexao.php';

// Captura os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Verifica se o e-mail já está registrado
$sql = "SELECT * FROM users WHERE user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('E-mail já cadastrado!'); window.location.href = 'index.php';</script>";
} else {
    // Criptografa a senha
    $senha_segura = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o novo cliente no banco de dados com o papel 'customer'
    $sql = "INSERT INTO users (user_email, user_senha, role) VALUES (?, ?, 'customer')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email, $senha_segura);
    
    if ($stmt->execute()) {
        // Após o cadastro, redireciona o usuário para a vitrine
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = '../showcase/index.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar! Tente novamente.'); window.location.href = 'index.php';</script>";
    }
}

$conn->close();
?>
