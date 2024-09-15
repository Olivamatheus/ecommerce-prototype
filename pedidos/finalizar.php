<?php
session_start();
include('../conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    die("Você precisa estar logado para finalizar o pedido.");
}

// Obtém o ID do usuário da sessão
$user_id = $_SESSION['user_id'];

// Calcula o valor total do pedido
$total = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $prod_id => $quantity) {
        $prod_id = intval($prod_id); // Certificar-se de que o ID é um número inteiro
        $sql = $conn->query("SELECT prod_price FROM products WHERE id = $prod_id");
        if ($sql) {
            $product = $sql->fetch_assoc();
            if ($product) {
                $total += $product['prod_price'] * $quantity;
            }
        }
    }
}

// Verifica se o ID do usuário é válido
$check_user = $conn->prepare("SELECT id FROM users WHERE id = ?");
$check_user->bind_param("i", $user_id);
$check_user->execute();
$result = $check_user->get_result();
if ($result->num_rows === 0) {
    die("Usuário não encontrado. Não é possível processar o pedido.");
}
$check_user->close();

// Insere o pedido na tabela
$sql = "INSERT INTO orders (customer_id, total_value, created_at) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("id", $user_id, $total);

if ($stmt->execute()) {
    // Limpar o carrinho após o pedido ser concluído
    unset($_SESSION['cart']);
    // Redirecionar para a vitrine de produtos
    header('Location: ../showcase/index.php');
    exit(); // Garantir que o script pare de executar após o redirecionamento
} else {
    echo "Erro ao finalizar pedido: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
