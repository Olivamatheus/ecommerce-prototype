<?php
session_start();
include('../conexao.php');

// Consulta para buscar todos os produtos
$sql_query = $conn->query("SELECT * FROM products") or die($conn->error);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitrine de Produtos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container-prods">
    <h1>Lista de Produtos</h1>
    <div class="showcase">
        <?php
        // Exibir produtos dinamicamente
        while ($produto = $sql_query->fetch_assoc()) {
            $prod_id = $produto['id'];
            $prod_nome = htmlspecialchars($produto['prod_name']);
            $prod_price = number_format($produto['prod_price'], 2, ',', '.');
            $img_path = htmlspecialchars($produto['img_path']);
            
            
            $full_img_path = "../uploads/" . $img_path;
        ?>
            <div class="product">
                <img src="<?php echo $full_img_path; ?>" alt="<?php echo $prod_nome; ?>" onerror="this.src='../uploads/default.png';">
                <p class="product-name"><?php echo $prod_nome; ?></p>
                <p class="rate">&#9733;&#9733;&#9733;&#9733;&#9733;</p>
                <p class="product-price"><span>R$</span><?php echo $prod_price; ?></p>
                <form action="../pedidos/adicionar_ao_carrinho.php" method="get">
                    <input type="hidden" name="prod_id" value="<?php echo $prod_id; ?>">
                    <button type="submit">Comprar</button>
                </form>
            </div>
        <?php
        }
        ?>
    </div>
    <a href="../pedidos/carrinho.php"><button>Carrinho</button></a> 
</div>

</body>
</html>
