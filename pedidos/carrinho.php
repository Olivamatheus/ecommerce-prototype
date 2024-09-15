<?php
session_start();
include('../conexao.php');

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Seu carrinho está vazio.";
    exit();
}

function calculateTotal($cart, $conn) {
    $total = 0;
    foreach ($cart as $prod_id => $quantity) {
        $prod_id = intval($prod_id); // Certificar-se de que o ID é um número inteiro
        $sql = $conn->query("SELECT prod_price FROM products WHERE id = $prod_id");
        if ($sql) {
            $product = $sql->fetch_assoc();
            if ($product) {
                $total += $product['prod_price'] * $quantity;
            }
        }
    }
    return $total;
}

$cart = $_SESSION['cart'];
$total = calculateTotal($cart, $conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h1>Carrinho</h1>
    <div class="cart-content">
        <?php
        foreach ($cart as $prod_id => $quantity) {
            $sql = $conn->query("SELECT * FROM products WHERE id = $prod_id");
            $produto = $sql->fetch_assoc();
            if ($produto) {
                $prod_nome = htmlspecialchars($produto['prod_name']);
                $prod_price = number_format($produto['prod_price'], 2, ',', '.');
                $img_path = htmlspecialchars($produto['img_path']);
                $full_img_path = "../uploads/" . $img_path;
        ?>
            <div class="pedido" data-price="<?php echo $produto['prod_price']; ?>">
                <img src="<?php echo $full_img_path; ?>" alt="<?php echo $prod_nome; ?>" onerror="this.src='../uploads/default.png';">
                <p class="product-name"><?php echo $prod_nome; ?></p>
                <p class="product-price"><span>R$</span><?php echo $prod_price; ?></p>
                <div class="quantity-control">
                    <span class="quantity"><?php echo $quantity; ?></span>
                </div>
            </div>
        <?php
            }
        }
        ?>
    </div>
    <h3>Total: R$<span id="total-price"><?php echo number_format($total, 2, ',', '.'); ?></span></h3>
    <a href="finalizar.php"><button>Finalizar Compra</button></a>
    <a href="../showcase/index.php"><button>Voltar à Vitrine</button></a>
</div>

</body>
</html>
