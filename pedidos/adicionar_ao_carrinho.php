<?php
session_start();
include('../conexao.php');

if (isset($_GET['prod_id'])) {
    $prod_id = intval($_GET['prod_id']);
    
    // Verificar se o carrinho já existe na sessão
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Adicionar o produto ao carrinho
    if (!isset($_SESSION['cart'][$prod_id])) {
        $_SESSION['cart'][$prod_id] = 1; // Inicializa a quantidade como 1
    } else {
        $_SESSION['cart'][$prod_id] += 1; // Incrementa a quantidade
    }

    // Redireciona para a página do carrinho
    header('Location: ../pedidos/carrinho.php');
    exit();
}
